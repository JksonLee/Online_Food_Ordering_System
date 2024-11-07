@extends('FrontEnd.master')

@section('title', 'Forgot Password')

@section('content')
<div class="container" style="max-width: 700px; margin-top: 80px;">
    <h3 class="text-center" style="font-size: 3rem; font-weight: bold; color: #007bff;">Forgot Password</h3>
    <p class="text-center" style="color: #6c757d; font-size: 1.5rem;">Enter your email address and we'll send you a link to reset your password.</p>

    @if(Session::has('success'))
        <div class="alert alert-success" style="margin-top: 30px; font-size: 1.25rem;">{{ Session::get('success') }}</div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger" style="margin-top: 30px; font-size: 1.25rem;">{{ Session::get('error') }}</div>
    @endif

    <form action="{{ route('password.custom.email') }}" method="post" style="margin-top: 40px; padding: 30px; border: 2px solid #ddd; border-radius: 12px; background-color: #f9f9f9;">
        @csrf
        <div class="form-group">
            <label for="email" style="font-size: 1.5rem; color: #333;">Email Address</label>
            <input type="email" name="email" class="form-control" style="padding: 15px; font-size: 1.25rem;" placeholder="Enter your email" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="padding: 15px 0; font-size: 1.5rem; margin-top: 25px;">Send Password Reset Link</button>
    </form>
    <br><br><br><br>
</div>

<!-- Styling for responsiveness -->
<style>
    @media (max-width: 768px) {
        .container {
            max-width: 100%;
            padding: 0 15px;
        }
    }
</style>
@endsection
