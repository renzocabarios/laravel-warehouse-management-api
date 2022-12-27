@extends('master')

@section('content')

<div class="d-flex p-2 justify-content-center">
    <form>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
        <a href="#">Register here</a>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
@endsection()