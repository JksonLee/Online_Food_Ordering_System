@extends('FrontEnd.master')

@section('title')
    Check Out
@endsection

@section('content')
@php
    $sum = request()->query('sum'); // Get the 'sum' from query parameter
@endphp
<style>
    /* Custom styles for Checkout page with blue color scheme */
.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    background-color: #007bff;
    color: #fff;
    padding: 30px;
    border-radius: 8px 8px 0 0;
}

.card-body h5 {
    font-weight: bold;
    font-size: 1.25rem;
    margin-bottom: 20px;
}

.table-hover {
    border-collapse: separate;
    border-spacing: 0 15px;
}

.table-hover tr {
    background-color: #f8f9fa;
}

.table-hover td {
    padding: 15px;
    font-size: 1.2rem;
}

.table-hover tr:hover {
    background-color: #e9ecef;
}

.btn-lg {
    padding: 15px;
    font-size: 1.2rem;
    border-radius: 50px;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Align center radio buttons */
input[type="radio"] {
    transform: scale(1.5);
    margin: 0 15px;
}

.fa-credit-card {
    color: #007bff;
}

.fa-money {
    color: #28a745;
}

.text-muted {
    margin-top: 10px;
}

.alert {
    font-size: 1rem;
    margin-bottom: 30px;
}

</style>

    <div class="products" style="margin-left:-200px;">
        <div class="container">
                 <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">
        <i class="fa fa-arrow-left"></i> Back to fill in the shipping info
    </a>
            <div class="col-md-9 product-w3ls-right">
                <!-- Session Alert -->
                @if(Session::get('sms'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ Session::get('sms') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                <!-- Checkout Card -->
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-4 rounded-top">
                        <h3>Dear {{ Session::get('customer_name') }},</h3>
                        <p style="color:white;">Which payment method you prefer?</p>
                    </div>

                    <div class="card-body">
                        <h5 class="text-center text-muted mb-4">Please select your payment method</h5>
                        <div class="checkout-left mt-4">
                            <div class="address_form_agile">

                                <!-- Payment Form -->
                                <form action="{{ route('new_order') }}" method="POST">
                                    @csrf

                                    <table class="table table-hover table-striped text-center mt-4">
                                        <tr>
                                            <td><i class="fa fa-money fa-2x text-success"></i></td>
                                            <td>Cash on Delivery</td>
                                            <td><input type="radio" name="payment_type" value="Cash" required> Cash</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-credit-card fa-2x text-primary"></i></td>
                                            <td>Stripe Card</td>
                                            <td><input type="radio" name="payment_type" value="Stripe"> Stripe</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <button type="submit" class="btn btn-primary btn-lg mt-3 w-100">Confirm Order</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Checkout Card -->
            </div>
        </div>
    </div>
@endsection
