@extends('master')

@section('content')
    <div class="h-full w-full p-2">

        <button type="button" class="btn btn-primary my-2 create">
            Add Branch
        </button>

        <table id="myTable" class="drop-shadow-2xl">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Branch Owner Full Name</th>
                    <th>Branch Owner Email</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

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

            if (localStorage.getItem('token') == null) window.location.replace(`${window.location.origin}/login`)

            $('#myTable').DataTable({
                ajax: 'api/branch',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: "branch_owner.user.firstName",
                        render: function(data, type, row, meta) {
                            return `${data} ${row.branch_owner.user.lastName}`
                        }
                    },
                    {
                        data: "branch_owner.user.email"
                    },
                    {
                        data: "id",
                        render: function(data, type, row, meta) {
                            return `<button id='${data}' class="btn btn-primary edit">Edit</button> <button id='${data}' class="btn btn-primary destroy">Delete</button>`
                        }
                    },
                ],
            });


            $('.form').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: `/api/user`,
                    data: $(this).serialize(),
                    success: function(data) {
                        window.location.replace(window.location.href);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            });

            $('.editForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    type: "PATCH",
                    dataType: 'json',
                    url: `/api/item/${$('#editId').val()}`,
                    data: $(this).serialize(),
                    success: function(data) {
                        window.location.replace(window.location.href);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            });



            $(document).on('click', '.create', function(event) {
                window.location.replace(`${window.location.origin}/branch/create`);

            });

            $(document).on('click', '.edit', function(event) {
                var id = $(this).attr('id');
                window.location.replace(`${window.location.origin}/branch/edit/${id}`);

            });


            $(document).on('click', '.destroy', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    url: `/api/branch/${id}`,
                    type: "DELETE",
                    dataType: "json",
                    success: function(data) {
                        window.location.replace(window.location.href);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });
        });
    </script>
@endpush
