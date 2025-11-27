<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <h1 class="ms-5 mt-3">Citizen Management System</h1>
    <h4 class="text-center text-primary mt-3">Add Citizen</h4>
    <div id="alertBox" style="margin-left: 70px; margin-right: 70px;"></div>
    <div class="container">
        <form>
            <input type="hidden" id="id" name="id">
            <div class="row mt-3">
                <div class="col-12 mt-3">
                    <label for="">State</label>
                    <select class="form-select" name="state_id" id="state_id">
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <label for="">Block</label>
                    <select class="form-select" name="block_id" id="block_id">
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <label for="">Panchayat</label>
                    <select class="form-select" name="panchayat_id" id="panchayat_id">
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <label for="">Village</label>
                    <select class="form-select" name="village_id" id="village_id">
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" name="citizen_name" id="citizen_name">
                </div>
                <div class="col-12 mt-3">
                    <label for="">Gender</label>
                    <select class="form-select" name="gender" id="gender">
                        <option value="">--Select Gender--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <label for="name">Phone</label>
                    <input class="form-control" type="text" name="citizen_phone" id="citizen_phone">
                </div>
                <div class="col-12 mt-3">
                    <label for="name">Email</label>
                    <input class="form-control" type="text" name="citizen_email" id="citizen_email">
                </div>
                <div>
                    <button class="btn btn-primary mt-3" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

            // 1. Load states
            let states = <?php echo json_encode($states); ?>;
            $('#state_id').append(`<option value="">--Select State--</option>`);
            states.forEach(s => {
                $('#state_id').append(`<option value="${s.id}">${s.state_name}</option>`);
            });

            // 2. Load blocks based on state
            $('#state_id').on('change', function() {
                let stateID = $(this).val();
                $('#block_id').empty();
                $('#panchayat_id').empty();
                $('#village_id').empty();

                $.get(`/get-blocks/${stateID}`, function(data) {
                    $('#block_id').append(`<option value="">--Select Block--</option>`);
                    data.forEach(b => {
                        $('#block_id').append(`<option value="${b.id}">${b.block_name}</option>`);
                    });
                });
            });

            // 3. Load panchayats based on block
            $('#block_id').on('change', function() {
                let blockID = $(this).val();
                $('#panchayat_id').empty();
                $('#village_id').empty();

                $.get(`/get-panchayats/${blockID}`, function(data) {
                    $('#panchayat_id').append(`<option value="">--Select Panchayat--</option>`);
                    data.forEach(p => {
                        $('#panchayat_id').append(`<option value="${p.id}">${p.panchayat_name}</option>`);
                    });
                });
            });

            // 4. Load villages based on panchayat
            $('#panchayat_id').on('change', function() {
                let panchID = $(this).val();
                $('#village_id').empty();

                $.get(`/get-villages/${panchID}`, function(data) {
                    $('#village_id').append(`<option value="">--Select Village--</option>`);
                    data.forEach(v => {
                        $('#village_id').append(`<option value="${v.id}">${v.village_name}</option>`);
                    });
                });
            });

            // 5. Submit form by AJAX
            $('form').on('submit', function(e) {
                e.preventDefault();

                let formData = {
                    village_id: $('#village_id').val(),
                    citizen_name: $('#citizen_name').val(),
                    gender: $('#gender').val(),
                    citizen_phone: $('#citizen_phone').val(),
                    citizen_email: $('#citizen_email').val(),
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    type: "POST",
                    url: "/citizens",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert("Citizen Added Successfully");
                            window.location.href = "/citizens";
                        }
                    },

                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let message = "<ul>";

                            $.each(errors, function(key, val) {
                                message += `<li>${val}</li>`;
                            });

                            message += "</ul>";

                            $("#alertBox").html(`
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                <strong>Error!</strong><br>${message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            `);
                        }
                    }
                });
            });

        });
    </script>

</body>

</html>