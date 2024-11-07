@extends('FrontEnd.master')

@section('title')
    Shipping
@endsection

@section('content')

<!-- Shipping-page -->
<div class="login-page about">
    <img class="login-w3img" src="{{ asset('frontEndSourceFile/images/img3.jpg') }}" alt="">
    <div class="container"> 
         <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">
        <i class="fa fa-arrow-left"></i> Back to Cart
    </a>
        <h3 class="w3ls-title w3ls-title1 text-center">Enter Your Shipping Information</h3>
        <p class="text-center">You can change your shipping information</p>
        <div class="login-agileinfo"> 
            <form action="{{ route('shipping.submit') }}" method="post"> 
                @csrf
                
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input class="form-control" id="name" type="text" name="name" placeholder="Enter your name" value="{{ $customer->name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" id="email" type="email" name="email" placeholder="Your Email" value="{{ $customer->email }}" required>
                </div>

                <div class="form-group">
                    <label for="phone_no">Phone Number</label>
                    <input class="form-control" id="phone_no" type="text" name="phone_no" placeholder="Your phone number" value="{{ $customer->phone_no }}" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input class="form-control" id="address" type="text" name="address" placeholder="Enter your address" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Enter</button>
            </form>
        </div> 
    </div>
</div>
<!-- //Shipping-page -->
@endsection
