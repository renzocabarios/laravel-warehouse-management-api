@extends('master')

@section('content')
    <div class="h-full w-full p-2">

        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#formModal">
            Add Stock
        </button>

        <table id="myTable" class="drop-shadow-2xl ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Branch Id</th>
                    <th>Item Id</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Add Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form">
                            <div class="mb-3">
                                <label for="branchId" class="form-label">Branch Id</label>
                                <input type="text" class="form-control" id="branchId" name="branchId">
                            </div>
                            <div class="mb-3">
                                <label for="itemId" class="form-label">Item Id</label>
                                <input type="text" class="form-control" id="itemId" name="itemId">
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Item Quantity</label>
                                <input type="text" class="form-control" id="quantity" name="quantity">
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
                        <h5 class="modal-title" id="formEditModalLabel">Edit Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="editForm">
                            <div class="mb-3">
                                <label for="editId" class="form-label">Stock Id</label>
                                <input type="text" class="form-control" id="editId" name="id">
                            </div>
                            <div class="mb-3">
                                <label for="editBranchId" class="form-label">Branch Id</label>
                                <input type="text" class="form-control" id="editBranchId" name="branchId">
                            </div>
                            <div class="mb-3">
                                <label for="editItemId" class="form-label">Item Id</label>
                                <input type="text" class="form-control" id="editItemId" name="itemId">
                            </div>
                            <div class="mb-3">
                                <label for="editQuantity" class="form-label">Quantity</label>
                                <input type="text" class="form-control" id="editQuantity" name="quantity">
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
                ajax: 'api/stock',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'branchId'
                    },
                    {
                        data: 'itemId'
                    },
                    {
                        data: 'quantity'
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
                    url: `/api/stock`,
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
                    url: `/api/stock/${$('#editId').val()}`,
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
                    url: `/api/stock/${id}`,
                    dataType: "json",
                    success: function(data) {
                        $('#editId').val(data.data[0].id);
                        $('#editBranchId').val(data.data[0].branchId);
                        $('#editItemId').val(data.data[0].itemId);
                        $('#editQuantity').val(data.data[0].quantity);
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
                    url: `/api/stock/${id}`,
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
