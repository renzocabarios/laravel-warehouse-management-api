@extends('master')

@section('content')
    <div class="h-full w-full">
        <div class="">
            <div class="d-flex gap-2 justify-content-evenly">
                <div class="w-25">
                    <div class="card w-100 my-2">
                        <div class="card-body">
                            <h5 class="card-title">Item Quantity</h5>
                            <p class="card-text">
                            <div class="mb-3">
                                <label for="itemId" class="form-label">Item ID</label>
                                <input type="text" class="form-control" id="itemId" name="itemId">
                            </div>

                            <div class="mb-3">
                                <label for="itemName" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="itemName" name="itemName">
                            </div>
                            <div class="mb-3">
                                <label for="itemDescription" class="form-label">Item Description</label>
                                <input type="text" class="form-control" id="itemDescription" name="itemDescription">
                            </div>

                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal"
                                data-bs-target="#formModal">Choose Item</button>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="text" class="form-control" id="quantity" name="quantity">
                            </div>

                            <button type="button" class="btn btn-primary my-2 add">Add Item Quantity</button>
                        </div>
                    </div>
                </div>
                <div class="w-25 itemsList"></div>
            </div>
            <div class="d-flex justify-content-center w-100">
                <button type="button" class="btn btn-primary my-2 px-4 submit">Submit</button>
            </div>
        </div>
        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Add Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="myTable" class="drop-shadow-2xl w-100">
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
            $('#myTable').DataTable({
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
                            return `<button id='${data}' class="btn btn-primary select" data-bs-dismiss="modal" >Select</button> `
                        }
                    },
                ],
            });

            $(document).on('click', '.select', function(event) {
                const id = $(this).attr('id');
                $.ajax({
                    url: `/api/item/${id}`,
                    dataType: "json",
                    success: function(data) {
                        $('#itemId').val(data.data[0].id);
                        $('#itemName').val(data.data[0].name);
                        $('#itemDescription').val(data.data[0].description);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });

            $(document).on('click', '.add', function(event) {
                var count = $(".itemsList").children().length;
                $(".itemsList").append(`
                    <div class="card w-100 my-2 itemTemp${count+1}">
                        <div class="card-body">
                            <h5 class="card-title">Item Quantity Details</h5>
                            <p class="card-text">
                            <div class="mb-3">
                                <label for="itemIdTemp" class="form-label">Item ID</label>
                                <input type="text" class="form-control" id="itemIdTemp${count+1}" name="itemIdTemp"
                                    value=${$('#itemId').val()}>
                            </div>
                            <div class="mb-3">
                                <label for="itemNameTemp" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="itemNameTemp${count+1}" name="itemNameTemp"
                                    value=${$('#itemName').val()}>
                            </div>
                            <div class="mb-3">
                                <label for="itemQuantityTemp" class="form-label">Item Quantity</label>
                                <input type="text" class="form-control" id="itemQuantityTemp${count+1}" name="itemQuantityTemp"
                                    value=${$('#quantity').val()}>
                            </div>
                            </p>
                            <button class="btn btn-primary delete" id=${count+1}>Delete</button>
                        </div>
                    </div>
                `);
            });

            $(document).on('click', '.submit', function(event) {

                var getUrlParameter = function getUrlParameter(sParam) {
                    var sPageURL = window.location.search.substring(1),
                        sURLVariables = sPageURL.split('&'),
                        sParameterName,
                        i;

                    for (i = 0; i < sURLVariables.length; i++) {
                        sParameterName = sURLVariables[i].split('=');

                        if (sParameterName[0] === sParam) {
                            return sParameterName[1] === undefined ? true : decodeURIComponent(
                                sParameterName[1]);
                        }
                    }
                    return false;
                };

                var vehicle = getUrlParameter('vehicle');
                var to = getUrlParameter('to');
                var from = getUrlParameter('from');
                var items = [];

                for (var index = 0; index < $(".itemsList").children().length; index++) {
                    items.push({
                        itemId: $(`#itemIdTemp${index+1}`).val(),
                        quantity: $(`#itemQuantityTemp${index+1}`).val(),
                    });
                }

                $.ajax({
                    url: `/api/shipment`,
                    dataType: "json",
                    method: "POST",
                    data: {
                        vehicleId: vehicle,
                        to,
                        from,
                        items,
                    },

                    success: function(data) {
                        window.location.replace(`${window.location.origin}/shipment`);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
                console.log(items);

            });

            $(document).on('click', '.delete', function(event) {
                const id = $(this).attr('id');
                $(`.itemTemp${id}`).remove();
            });
        });
    </script>
@endpush
