@extends('master')

@section('content')
    <div class="h-full w-full">
        <div class="">
            <div class="d-flex gap-2 justify-content-evenly">
                <div class="w-25">
                    <div class="mb-3">
                        <label for="ownerId" class="form-label">Owner ID</label>
                        <input type="text" class="form-control" id="ownerId" name="ownerId">
                    </div>

                    <div class="mb-3">
                        <label for="ownerFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="ownerFirstName" name="ownerFirstName">
                    </div>
                    <div class="mb-3">
                        <label for="ownerLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="ownerLastName" name="ownerLastName">
                    </div>
                    <div class="mb-3">
                        <label for="ownerEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="ownerEmail" name="ownerEmail">
                    </div>
                    <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal"
                        data-bs-target="#formModal">Choose Branch Owner</button>


                </div>
                <div class="w-25">
                    <div class="mb-3">
                        <label for="name" class="form-label">Branch Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Branch Address</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center w-100">
                <button type="button" class="btn btn-primary my-2 px-4  submit">Submit</button>
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
                                    <th>Branch Owner Full Name</th>
                                    <th>Branch Email</th>
                                    <th>Type</th>
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
                ajax: '/api/branch-owner',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: "user.firstName",
                        render: function(data, type, row, meta) {
                            return `${data} ${row.user.lastName}`
                        }
                    },
                    {
                        data: 'user.email'
                    },
                    {
                        data: 'user.type'
                    },
                    {
                        data: "id",
                        render: function(data, type, row, meta) {
                            return `<button id='${row.userId}' class="btn btn-primary select" data-bs-dismiss="modal">Select</button> `
                        }
                    },
                ],
            });



            $(document).on('click', '.select', function(event) {
                const id = $(this).attr('id');
                $.ajax({
                    url: `/api/branch-owner/${id}`,
                    dataType: "json",
                    success: function(data) {
                        $('#ownerId').val(data.data[0].id);
                        $('#ownerEmail').val(data.data[0].user.email);
                        $('#ownerFirstName').val(data.data[0].user.firstName);
                        $('#ownerLastName').val(data.data[0].user.lastName);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });

            $(document).on('click', '.submit', function(event) {
                console.log($('#ownerId').val(), $('#name').val(), $('#address').val(),
                    $('#ownerLastName').val());

                $.ajax({
                    url: `/api/branch`,
                    dataType: "json",
                    method: "POST",
                    data: {
                        address: $('#address').val(),
                        branchOwnerId: $('#ownerId').val(),
                        name: $('#name').val(),
                    },

                    success: function(data) {
                        window.location.replace(`${window.location.origin}/branch`);

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
