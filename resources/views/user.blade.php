@extends('master')

@section('content')

<div class="h-full w-full p-2">

<button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#formModal">
Add User
</button>

<table id="myTable" class="drop-shadow-2xl ">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName">
                    </div>

                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formEditModalLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="editForm">
                    <div class="mb-3">
                        <label for="editId" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="editId" name="id">
                    </div>
                    <div class="mb-3">
                        <label for="editName" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="editName" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Item Description</label>
                        <input type="text" class="form-control" id="editDescription" name="description">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection()

@push('scripts')
<script>
    $(document).ready(() => {
        $('#myTable').DataTable({
            ajax: 'api/user',
            columns: [
                { data: 'id' },
                {
                    data: "firstName", render: function (data, type, row, meta) {
                        return `${data} ${row.lastName}`
                    }
                },
                { data: 'email' },
                { data: 'type' },
                {
                    data: "id", render: function (data, type, row, meta) {
                        return `<button id='${data}' class="btn btn-primary edit" data-bs-toggle="modal" data-bs-target="#formEditModal">Edit</button> <button id='${data}' class="btn btn-primary destroy">Delete</button> `
                    }
                },
            ],
        });


        $('.form').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: `/api/user`,
                data: $(this).serialize(),
                success: function (data) {
                    window.location.replace(window.location.href);
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        });

        $('.editForm').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                type: "PATCH",
                dataType: 'json',
                url: `/api/item/${$('#editId').val()}`,
                data: $(this).serialize(),
                success: function (data) {
                    window.location.replace(window.location.href);
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        });

        $(document).on('click', '.edit', function (event) {
            const id = $(this).attr('id');
            $.ajax({
                url: `/api/item/${id}`,
                dataType: "json",
                success: function (data) {
                    $('#editId').val(data.data[0].id);
                    $('#editName').val(data.data[0].name);
                    $('#editDescription').val(data.data[0].description);
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            })
        });


        $(document).on('click', '.destroy', function (event) {
            event.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: `/api/item/${id}`,
                type: "DELETE",
                dataType: "json",
                success: function (data) {
                    window.location.replace(window.location.href);
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            })
        });
    });
</script>
@endpush