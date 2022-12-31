@extends('master')

@section('content')
    <div class="h-full w-full p-2">

        <button type="button" class="btn btn-primary my-2 create">
            Add Shipment
        </button>

        <table id="myTable" class="drop-shadow-2xl">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>To</th>
                    <th>From</th>
                    <th>Item No.</th>
                    <th>Vehicle</th>
                    <th>Approved</th>
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
            $('#myTable').DataTable({
                ajax: 'api/shipment',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'to.name'
                    },
                    {
                        data: 'from.name'
                    },

                    {
                        data: "shipment_items",
                        render: function(data, type, row, meta) {
                            return `${data.length}`
                        }
                    },
                    {
                        data: "vehicle",
                        render: function(data, type, row, meta) {
                            return `${data.color} | ${data.model}`
                        }
                    },
                    {
                        data: "isApproved",
                        render: function(data, type, row, meta) {
                            return data ? "APPROVED" : "NOT APPROVED"
                        }
                    },

                    {
                        data: "id",
                        render: function(data, type, row, meta) {
                            return `<button id='${data}' class="btn btn-primary edit">Edit</button> <button id='${data}' class="btn btn-primary destroy">Delete</button> <button id='${data}' class="btn btn-primary approve">Approve</button>`
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
                window.location.replace(`${window.location.origin}/shipment/create`);

            });

            $(document).on('click', '.edit', function(event) {
                var id = $(this).attr('id');
                window.location.replace(`${window.location.origin}/branch/edit/${id}`);

            });

            $(document).on('click', '.approve', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    url: `/api/shipment/${id}/approve`,
                    type: "PATCH",
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

            $(document).on('click', '.destroy', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    url: `/api/shipment/${id}`,
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
