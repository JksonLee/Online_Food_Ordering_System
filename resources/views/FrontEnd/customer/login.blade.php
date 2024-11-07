@extends('FrontEnd.master')

@section('title')
    Sign In
@endsection

@section('content')

<!-- Custom CSS for Sign In page -->
<style>
  .login-page {
    background-color: #f8f9fa;
    padding: 50px 0;
}

.w3ls-title1 {
    font-size: 2rem;
    color: #333;
}

.form-control {
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    padding: 15px;
    font-size: 1.2rem;
    border-radius: 5px;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.alert {
    margin-bottom: 20px;
    font-size: 1rem;
}

.login-agileinfo {
    background: #ffffff;
    padding: 30px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}
</style>

<div class="login-page about">
    <div class="container"> 
        <h3 class="w3ls-title w3ls-title1 text-center">Sign In to your account</h3> 

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="login-agileinfo mx-auto mt-5" style="max-width: 500px;"> 
            <form action="{{ route('login.submit') }}" method="post" onsubmit="return validatePasswords()"> 
                @csrf
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input class="form-control" type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

              
                <!-- Show Password Checkbox -->
                <div class="form-check mt-2">
                    <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePasswordVisibility()">
                    <label class="form-check-label" for="showPassword">Show Password</label>
                </div>

                <!-- Forgot Password Link -->
                <div class="form-group text-right mt-3">
                    <a href="{{  route('password.custom.request') }}" class="text-primary">Forgot Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </form>
            <br>
            <!-- Additional Links -->
            <div class="text-center mt-4">
                <p class="mb-1">Don't have an account? <a href="{{route('sign_up')}}" class="text-primary">Register here</a></p>
                <p class="mb-0">Are you an admin? <a href="{{ route('admin.login')}}" class="text-primary">Admin Login</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Frontend JavaScript for password matching and visibility toggle -->
<script>
function validatePasswords() {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm-password').value;
    
    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return false;
    }
    return true;
}

function togglePasswordVisibility() {
    var password = document.getElementById('password');
    var confirmPassword = document.getElementById('confirm-password');
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
