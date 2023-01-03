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
                            data-bs-target="#formModal">Choose Shipment</button>
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
                            <input type="text" class="form-control" id="itemId" name="itemId">
                        </div>
                        <div class="mb-3">
                            <label for="itemName" class="form-label">Item</label>
                            <input type="text" class="form-control" id="itemName" name="itemName">
                        </div>


                        <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal"
                            data-bs-target="#formItem">Choose Item </button>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity" name="quantity">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center w-100">
            <button class="btn btn-primary my-2 px-4 submit">Submit</button>
        </div>


        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Add Shipment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="myTable" class="drop-shadow-2xl w-100">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="formItem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Add Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="myTableItem" class="drop-shadow-2xl w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
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
                ajax: '/api/shipment',
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
                            return `<button id='${data}' class="btn btn-primary select" data-bs-dismiss="modal">Select</button> `
                        }
                    },
                ],
            });

            $('#myTableItem').DataTable({
                ajax: '/api/item',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: "id",
                        render: function(data, type, row, meta) {
                            return `<button id='${data}' class="btn btn-primary itemSelect" data-bs-dismiss="modal">Select</button> `
                        }
                    },
                ],
            });


            $(document).on('click', '.itemSelect', function(event) {
                const id = $(this).attr('id');

                $.ajax({
                    url: `/api/item/${id}`,
                    dataType: "json",
                    success: function(data) {
                        $('#itemId').val(data.data[0].id);
                        $('#itemName').val(
                            data.data[0].name
                        );

                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });


            $(document).on('click', '.select', function(event) {
                event.preventDefault();
                const id = $(this).attr('id');

                $.ajax({
                    url: `/api/shipment/${id}`,
                    dataType: "json",
                    success: function(data) {
                        $('#shipmentId').val(data.data[0].id);
                        $('#to').val(`${data.data[0].to.name} | ${data.data[0].to.address}`);
                        $('#from').val(
                            `${data.data[0].from.name} | ${data.data[0].from.address}`);
                        $('#vehicle').val(
                            `${data.data[0].vehicle.color} | ${data.data[0].vehicle.model}`);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });
            $(document).on('click', '.submit', function(event) {
                event.preventDefault();

                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: `/api/shipment-item`,
                    data: {
                        shipmentId: $('#shipmentId').val(),
                        itemId: $('#itemId').val(),
                        quantity: $('#quantity').val(),
                    },
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
                        // window.location.replace(window.location.href);
                        console.log(data);
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
