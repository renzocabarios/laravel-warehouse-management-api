@extends('master')

@section('content')
    <div class="h-full w-full">
        <div class="">
            <div class="d-flex gap-2 justify-content-evenly">
                <div class="w-25">
                    <div class="card w-100 my-2">
                        <div class="card-body">
                            <h5 class="card-title">To Branch</h5>
                            <p class="card-text">
                            <div class="mb-3">
                                <label for="toBranchId" class="form-label">Branch ID</label>
                                <input type="text" class="form-control" id="toBranchId" name="toBranchId">
                            </div>
                            <div class="mb-3">
                                <label for="toBranchName" class="form-label">Branch Name</label>
                                <input type="text" class="form-control" id="toBranchName" name="toBranchName">
                            </div>
                            <div class="mb-3">
                                <label for="toBranchAddress" class="form-label">Branch Address</label>
                                <input type="text" class="form-control" id="toBranchAddress" name="toBranchAddress">
                            </div>
                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal"
                                data-bs-target="#formToModal">Choose To Branch</button>
                        </div>
                    </div>

                    <div class="card w-100 my-2">
                        <div class="card-body">
                            <h5 class="card-title">From Branch</h5>
                            <p class="card-text">
                            <div class="mb-3">
                                <label for="fromBranchId" class="form-label">Branch ID</label>
                                <input type="text" class="form-control" id="fromBranchId" name="fromBranchId">
                            </div>

                            <div class="mb-3">
                                <label for="fromBranchName" class="form-label">Branch Name</label>
                                <input type="text" class="form-control" id="fromBranchName" name="fromBranchName">
                            </div>
                            <div class="mb-3">
                                <label for="fromBranchAddress" class="form-label">Branch Address</label>
                                <input type="text" class="form-control" id="fromBranchAddress" name="fromBranchAddress">
                            </div>
                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal"
                                data-bs-target="#formFromModal">Choose To Branch</button>
                        </div>
                    </div>
                </div>

                <div class="w-25">
                    <div class="card w-100 my-2">
                        <div class="card-body">
                            <h5 class="card-title">Vehicle</h5>
                            <p class="card-text">
                            <div class="mb-3">
                                <label for="vehicleId" class="form-label">Vehicle ID</label>
                                <input type="text" class="form-control" id="vehicleId" name="vehicleId">
                            </div>

                            <div class="mb-3">
                                <label for="vehicleModel" class="form-label">Vehicle Model</label>
                                <input type="text" class="form-control" id="vehicleModel" name="vehicleModel">
                            </div>

                            <div class="mb-3">
                                <label for="vehicleColor" class="form-label">Vehicle Color</label>
                                <input type="text" class="form-control" id="vehicleColor" name="vehicleColor">
                            </div>
                            <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal"
                                data-bs-target="#vehicleModal">Choose Vehicle </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center w-100">
                <button type="button" class="btn btn-primary my-2 px-4 next">Next</button>
            </div>
        </div>

        <div class="modal fade" id="formToModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Select a Branch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="myTableToBranch" class="drop-shadow-2xl w-100">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="formFromModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Select a Branch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="myTableFromBranch" class="drop-shadow-2xl w-100">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Select a Branch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table id="myTableVehicle" class="drop-shadow-2xl w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Color</th>
                                    <th>Model</th>
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

            $('#myTableToBranch').DataTable({
                ajax: '/api/branch',
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
                            return `<button id='${data}' class="btn btn-primary toSelectTo" data-bs-dismiss="modal">Select</button> `
                        }
                    },
                ],
            });

            $('#myTableFromBranch').DataTable({
                ajax: '/api/branch',
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
                            return `<button id='${data}' class="btn btn-primary toSelectFrom" data-bs-dismiss="modal">Select</button> `
                        }
                    },
                ],
            });

            $('#myTableVehicle').DataTable({
                ajax: '/api/vehicle',
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
                            return `<button id='${data}' class="btn btn-primary selectVehicle" data-bs-dismiss="modal">Select</button> `
                        }
                    },
                ],
            });

            $(document).on('click', '.toSelectTo', function(event) {

                const id = $(this).attr('id');
                $.ajax({
                    url: `/api/branch/${id}`,
                    dataType: "json",
                    success: function(data) {
                        $('#toBranchId').val(data.data[0].id);
                        $('#toBranchName').val(data.data[0].name);
                        $('#toBranchAddress').val(data.data[0].address);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });


            $(document).on('click', '.toSelectFrom', function(event) {

                const id = $(this).attr('id');
                $.ajax({
                    url: `/api/branch/${id}`,
                    dataType: "json",
                    success: function(data) {
                        $('#fromBranchId').val(data.data[0].id);
                        $('#fromBranchName').val(data.data[0].name);
                        $('#fromBranchAddress').val(data.data[0].address);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });

            $(document).on('click', '.selectVehicle', function(event) {

                const id = $(this).attr('id');
                $.ajax({
                    url: `/api/vehicle/${id}`,
                    dataType: "json",
                    success: function(data) {
                        $('#vehicleId').val(data.data[0].id);
                        $('#vehicleModel').val(data.data[0].model);
                        $('#vehicleColor').val(data.data[0].color);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });

            $(document).on('click', '.next', function(event) {
                window.location.replace(
                    `${window.location.origin}/shipment/create-item?to=${$('#toBranchId').val()}&from=${$('#fromBranchId').val()}&vehicle=${$('#vehicleId').val()}`
                );
            });
        });
    </script>
@endpush
