<!DOCTYPE html>
<!-- @extends('layouts.app') -->

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <div class="text-center mb-3">
            <img src="{{ asset('images/logo.png') }}" alt="RecycleX Logo" width="100">
            <h4 class="mt-2">Log In</h4>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Log In</button>
        </form>

        <div class="text-center mt-3">
            <a href="#">Forgot Password?</a>
        </div>

        <div class="text-center mt-3">
            <p>Or log in with</p>
            <a href="#" class="btn btn-light w-100 mb-2">
                <img src="{{ asset('images/google-logo.png') }}" width="20" class="me-2"> Google
            </a>
            <a href="#" class="btn btn-light w-100">
                <img src="{{ asset('images/facebook-logo.png') }}" width="20" class="me-2"> Facebook
            </a>
        </div>
    </div>
</div>
<!-- @endsection -->
