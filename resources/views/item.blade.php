@extends('master')
@section('content')

<div class="h-full w-full p-4">
    <table id="myTable" class="drop-shadow-2xl ">
    <thead>
    <tr>
    <th>id</th>
    <th>Name</th>
    <th>Description</th>
    </tr>
</thead>
</table>
</div>
@endsection()

@push('scripts')

<script>
    $(document).ready(function () {
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