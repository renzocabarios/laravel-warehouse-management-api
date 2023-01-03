@extends('master')

@section('content')
    <div class="h-full w-full p-2">

        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#formModal">
            Add Vehicle
        </button>

        <table id="myTable" class="drop-shadow-2xl ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Color</th>
                    <th>Model</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Add Vehicle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form">
                            <div class="mb-3">
                                <label for="color" class="form-label">Vehicle Color</label>
                                <input type="text" class="form-control" id="color" name="color">
                            </div>
                            <div class="mb-3">
                                <label for="model" class="form-label">Vehicle Model</label>
                                <input type="text" class="form-control" id="model" name="model">
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
                        <h5 class="modal-title" id="formEditModalLabel">Edit Vehicle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="editForm">
                            <div class="mb-3">
                                <label for="editId" class="form-label">Vehicle Id</label>
                                <input type="text" class="form-control" id="editId" name="id">
                            </div>
                            <div class="mb-3">
                                <label for="editColor" class="form-label">Vehicle Color</label>
                                <input type="text" class="form-control" id="editColor" name="color">
                            </div>
                            <div class="mb-3">
                                <label for="editModel" class="form-label">Vehicle Model</label>
                                <input type="text" class="form-control" id="editModel" name="model">
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
                ajax: 'api/vehicle',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'color'
                    },
                    {
                        data: 'model'
                    },
                    {
                        data: "id",
                        render: function(data, type, row, meta) {
                            return `<button id='${data}' class="btn btn-primary edit" data-bs-toggle="modal" data-bs-target="#formEditModal">Edit</button> <button id='${data}' class="btn btn-primary destroy">Delete</button> `
                        }
                    },
                ],
            });


            $('.form').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: `/api/vehicle`,
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
                    url: `/api/vehicle/${$('#editId').val()}`,
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

            $(document).on('click', '.edit', function(event) {
                const id = $(this).attr('id');

                $.ajax({
                    url: `/api/vehicle/${id}`,
                    dataType: "json",
                    success: function(data) {
                        $('#editId').val(data.data[0].id);
                        $('#editColor').val(data.data[0].color);
                        $('#editModel').val(data.data[0].model);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });


            $(document).on('click', '.destroy', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    url: `/api/vehicle/${id}`,
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
