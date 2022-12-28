@extends('master')

@section('content')

<div class="h-full w-full p-2">

<button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#formModal">
Add Item
</button>

<table id="myTable" class="drop-shadow-2xl ">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Add Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form">
                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Item Description</label>
                        <input type="text" class="form-control" id="description" name="description">
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
            ajax: 'api/item',
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'description' },
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
                url: `/api/item`,
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