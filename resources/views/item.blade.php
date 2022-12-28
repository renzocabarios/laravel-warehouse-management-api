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
                <form>
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
            ],
        });
    });
</script>
@endpush