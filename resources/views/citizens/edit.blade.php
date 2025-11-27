<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Citizen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>

<body>
    <h1 class="ms-5 mt-3">Citizen Management System</h1>
    <h4 class="text-center text-warning mt-3">Edit Citizen</h4>
    <div class="container">
        <form id="editForm">
            <input type="hidden" id="id" value="{{ $citizen->id }}">

            <div class="row mt-3">
                <!-- State -->
                <div class="col-12 mt-3">
                    <label>State</label>
                    <select class="form-select" id="state_id"></select>
                </div>

                <!-- Block -->
                <div class="col-12 mt-3">
                    <label>Block</label>
                    <select class="form-select" id="block_id"></select>
                </div>

                <!-- Panchayat -->
                <div class="col-12 mt-3">
                    <label>Panchayat</label>
                    <select class="form-select" id="panchayat_id"></select>
                </div>

                <!-- Village -->
                <div class="col-12 mt-3">
                    <label>Village</label>
                    <select class="form-select" id="village_id"></select>
                </div>

                <div class="col-12 mt-3">
                    <label>Name</label>
                    <input class="form-control" type="text" id="citizen_name" value="{{ $citizen->citizen_name }}">
                </div>

                <div class="col-12 mt-3">
                    <label>Gender</label>
                    <select class="form-select" id="gender">
                        <option value="">--Select--</option>
                        <option value="Male" {{ $citizen->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $citizen->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $citizen->gender == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="col-12 mt-3">
                    <label>Phone</label>
                    <input class="form-control" type="text" id="citizen_phone" value="{{ $citizen->citizen_phone }}">
                </div>

                <div class="col-12 mt-3">
                    <label>Email</label>
                    <input class="form-control" type="text" id="citizen_email" value="{{ $citizen->citizen_email }}">
                </div>
                <div>
                    <button class="btn btn-primary mt-3" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            let states = <?php echo json_encode($states); ?>;
            let citizen = <?php echo json_encode($citizen); ?>;
            // 1. Load States

            $('#state_id').append(`<option value="">--Select State--</option>`);

            states.forEach(s => {
                $('#state_id').append(`<option value="${s.id}">${s.state_name}</option>`);
            });

            // Set selected state
            let selectedState = citizen.village.panchayat.block.state_id;
            $('#state_id').val(selectedState).change();

            // 2. Load Blocks (Auto-select)

            $.get(`/get-blocks/${selectedState}`, function(blocks) {

                $('#block_id').append(`<option value="">--Select Block--</option>`);
                blocks.forEach(b => {
                    $('#block_id').append(`<option value="${b.id}">${b.block_name}</option>`);
                });

                let selectedBlock = citizen.village.panchayat.block_id;
                $('#block_id').val(selectedBlock).change();
            });

            // 3. Load Panchayats (Auto-select)

            $('#block_id').on('change', function() {
                let blockID = $(this).val();

                $('#panchayat_id').empty();
                $('#village_id').empty();

                $.get(`/get-panchayats/${blockID}`, function(panchayats) {

                    $('#panchayat_id').append(`<option value="">--Select Panchayat--</option>`);
                    panchayats.forEach(p => {
                        $('#panchayat_id').append(`<option value="${p.id}">${p.panchayat_name}</option>`);
                    });

                    let selectedPanchayat = citizen.village.panchayat_id;
                    $('#panchayat_id').val(selectedPanchayat).change();
                });
            });

            // 4. Load Villages (Auto-select)

            $('#panchayat_id').on('change', function() {
                let panchID = $(this).val();

                $('#village_id').empty();

                $.get(`/get-villages/${panchID}`, function(villages) {

                    $('#village_id').append(`<option value="">--Select Village--</option>`);
                    villages.forEach(v => {
                        $('#village_id').append(`<option value="${v.id}">${v.village_name}</option>`);
                    });

                    $('#village_id').val(citizen.village_id);
                });
            });

            // 5. Update AJAX

            $('#editForm').on('submit', function(e) {
                e.preventDefault();

                let id = $('#id').val();

                let formData = {
                    village_id: $('#village_id').val(),
                    citizen_name: $('#citizen_name').val(),
                    gender: $('#gender').val(),
                    citizen_phone: $('#citizen_phone').val(),
                    citizen_email: $('#citizen_email').val(),
                    _token: "{{ csrf_token() }}",
                    _method: "PUT"
                };

                $.post(`/citizens/${id}`, formData, function(response) {
                    if (response.success) {
                        alert("Citizen Updated Successfully!");
                        window.location.href = "/citizens";
                    }
                });
            });

        });
    </script>

</body>

</html>