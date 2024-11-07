@extends('FrontEnd.master')

@section('title')
    Register a Customer
@endsection

@section('content')
<style>
    /* Adjust the spacing for the form */
    .agile-ltext {
        margin-bottom: 15px;
    }

    .wthreelogin-text {
        margin-top: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px;
        font-size: 1rem;
        border-radius: 5px;
        width: 100%;
    }

    .text-primary {
        color: #007bff;
        font-weight: 500;
    }

</style>

<!-- sign up-page -->
<div class="login-page about">
    <img class="login-w3img" src="{{asset('/') }}frontEndSourceFile/images/img3.jpg" alt="">
    <div class="container"> 
        <h3 class="w3ls-title w3ls-title1">Sign Up for an account</h3>  

        <!-- Flash message for errors -->
        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        <div class="login-agileinfo"> 
            <form action="{{ route('register.submit') }}" method="post">
                @csrf

                <!-- Name Field -->
                <input class="agile-ltext form-control" type="text" name="name" placeholder="Enter your name" required>

                <!-- Email Field -->
                <input class="agile-ltext form-control" type="email" name="email" placeholder="Enter your email" required>

                <!-- Phone Field -->
                <input class="agile-ltext form-control" type="text" name="phone_no" placeholder="Enter your phone number" required>

                <!-- Password Field -->
                <input class="agile-ltext form-control" type="password" name="password" id="password" placeholder="Enter your password" required>

                <!-- Confirm Password Field -->
                <input class="agile-ltext form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required>

                <!-- Show Password Checkbox -->
                <div class="form-check mt-2">
                    <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePasswordVisibility()">
                    <label class="form-check-label" for="showPassword">Show Password</label>
                </div>

                <!-- Terms of Service Checkbox -->
                <div class="wthreelogin-text mt-3"> 
                    <ul> 
                        <li>
                            <label class="checkbox">
                                <input type="checkbox" name="checkbox" required>
                                <i></i> 
                                <span> I agree to the terms of service</span>
                            </label> 
                        </li> 
                    </ul>
                    <div class="clearfix"></div>
                </div>   

                <!-- Submit Button -->
                <input type="submit" style="background-color:#007bff;" class="btn btn-primary mt-3" value="Sign Up">
            </form>

            <!-- Already have an account? -->
            <div class="text-center mt-4">
                <p>Already have an account? <a href="{{ route('login_in') }}" class="text-primary">Login here</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Add JavaScript to handle password visibility toggle -->
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
