@extends('FrontEnd.master')

@section('title', 'Reset Password')

@section('content')
<div class="container" style="max-width: 600px; margin-top: 50px;">
    <h3 class="text-center" style="font-size: 2.5rem; font-weight: bold; color: #007bff;">Reset Password</h3>
    <p class="text-center" style="color: #6c757d; font-size: 1.2rem;">Please enter your new password below.</p>

    @if ($errors->any())
        <div class="alert alert-danger" style="margin-top: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.custom.reset') }}" method="post" style="margin-top: 30px; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email Input -->
        <div class="form-group">
            <label for="email" style="font-size: 1.3rem;">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" style="padding: 15px; font-size: 1.25rem;" required>
        </div>

        <!-- New Password Input -->
        <div class="form-group">
            <label for="password" style="font-size: 1.3rem;">New Password</label>
            <input type="password" name="password" id="password" class="form-control" style="padding: 15px; font-size: 1.25rem;" required>
        </div>

        <!-- Confirm Password Input -->
        <div class="form-group">
            <label for="password_confirmation" style="font-size: 1.3rem;">Confirm Password</label>
            <input type="password" name="password_confirmation" id="confirm_password" class="form-control" style="padding: 15px; font-size: 1.25rem;" required>
        </div>

        <!-- Show Password Checkbox -->
        <div class="form-check" style="margin-top: 15px;">
            <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePasswordVisibility()">
            <label class="form-check-label" for="showPassword" style="font-size: 1.1rem;">Show Password</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary btn-block" style="padding: 15px 0; font-size: 1.3rem; margin-top: 25px;">Reset Password</button>
    </form>
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

<!-- JavaScript for Show Password Feature -->
<script>
    function togglePasswordVisibility() {
        var password = document.getElementById("password");
        var confirmPassword = document.getElementById("confirm_password");
        if (password.type === "password") {
            password.type = "text";
            confirmPassword.type = "text";
        } else {
            password.type = "password";
            confirmPassword.type = "password";
        }
    }
</script>
@endsection
