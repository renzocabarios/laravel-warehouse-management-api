@extends('master')

@section('content')
    <div class="h-full w-full p-2">

        <div class="d-flex gap-2 justify-content-evenly">
            <div class="w-25">
                <div class="card w-100 my-2">
                    <div class="card-body">
                        <h5 class="card-title">Shipment</h5>
                        <p class="card-text">
                        <div class="mb-3">
                            <label for="shipmentId" class="form-label">Shipment ID</label>
                            <input type="text" class="form-control" id="shipmentId" name="shipmentId">
                        </div>
                        <div class="mb-3">
                            <label for="to" class="form-label">To Branch</label>
                            <input type="text" class="form-control" id="to" name="to">
                        </div>
                        <div class="mb-3">
                            <label for="from" class="form-label">From Branch</label>
                            <input type="text" class="form-control" id="from" name="from">
                        </div>
                        <div class="mb-3">
                            <label for="vehicle" class="form-label">Vehicle</label>
                            <input type="text" class="form-control" id="vehicle" name="vehicle">
                        </div>
                        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal"
                            data-bs-target="#formToModal">Choose Shipment</button>
                    </div>
                </div>


            </div>

            <div class="w-25">
                <div class="card w-100 my-2">
                    <div class="card-body">
                        <h5 class="card-title">Item</h5>
                        <p class="card-text">
                        <div class="mb-3">
                            <label for="itemId" class="form-label">Item ID</label>
                            <input type="text" class="form-control" id="vehicleId" name="vehicleId">
                        </div>
                        <div class="mb-3">
                            <label for="ItemName" class="form-label">Item</label>
                            <input type="text" class="form-control" id="ItemName" name="ItemName">
                        </div>


                        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal"
                            data-bs-target="#vehicleModal">Choose Item </button>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity" name="quantity">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center w-100">
            <button type="button" class="btn btn-primary my-2 px-4 next">Submit</button>
        </div>
    </div>
@endsection()

@push('scripts')
    <script>
        $(document).ready(() => {
            $('#myTable').DataTable({
                ajax: 'api/shipment-item',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'shipment.to.name'
                    },
                    {
                        data: 'shipment.from.name'
                    },
                    {
                        data: 'item.name'
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
                    url: `/api/item`,
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

            $(document).on('click', '.edit', function(event) {
                const id = $(this).attr('id');

                $.ajax({
                    url: `/api/item/${id}`,
                    dataType: "json",
                    success: function(data) {
                        $('#editId').val();
                        $('#editName').val();
                        $('#editDescription').val();
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
                    url: `/api/shipment-item/${id}`,
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
