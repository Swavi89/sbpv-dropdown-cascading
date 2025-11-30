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
    <div class="float-end mb-2 me-3">
        <a href="{{ url('citizens/create') }}" class="btn btn-primary">Add Citizen</a>
    </div>
    <div class="container">
        <table class="table table-responsive table-hover mt-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>State</th>
                    <th>Block</th>
                    <th>Panchayat</th>
                    <th>Village</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody id="citizen_list"></tbody>
            @foreach($citizens as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>{{ $c->citizen_name }}</td>
                <td>{{ $c->village->panchayat->block->state->state_name }}</td>
                <td>{{ $c->village->panchayat->block->block_name }}</td>
                <td>{{ $c->village->panchayat->panchayat_name }}</td>
                <td>{{ $c->village->village_name }}</td>
                <td>{{ $c->gender }}</td>
                <td>{{ $c->citizen_phone }}</td>
                <td>{{ $c->citizen_email }}</td>

                <td><a href="{{ url('citizens/' . $c->id . '/edit') }}"><i class="fas fa-edit"></i></a></td>
                <td><a role="button" class="delete-btn" value="{{ $c->id }}"><i class="fas fa-trash text-danger"></i></a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Delete citizen
            $(document).on("click", ".delete-btn", function() {
                let id = $(this).attr("value");

                if (!confirm("Are you sure you want to delete this citizen?")) {
                    return;
                }

                $.ajax({
                    url: `/citizens/${id}`,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        alert("Citizen deleted successfully!");
                        window.location.href = "/citizens";
                    }
                });
            });
        });
    </script>

</body>

</html>