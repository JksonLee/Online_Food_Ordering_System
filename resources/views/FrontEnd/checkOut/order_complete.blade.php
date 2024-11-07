@extends('FrontEnd.master')

@section('title')
    Order | Complete
@endsection

@section('content')

<style>
    /* Custom styles for order completion page */
.alert {
    font-size: 1.2rem;
}

.card {
    border-radius: 15px;
}

.card-body {
    padding: 50px;
    background-color: #f8f9fa;
    border-radius: 15px;
}

.card-body h2 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 20px;
}

.card-body p {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 30px;
}

.fa-check-circle {
    color: #28a745;
}

.btn-lg {
    padding: 15px 30px;
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

</style>
    <div class="products" style="margin-left:-250px;">
        <div class="container">
            <div class="col-md-9 product-w3ls-right">
                <!-- Flash message -->
                @if(Session::has('success'))
                    <div class="alert alert-success text-center alert-dismissible fade show mt-3" role="alert">
                        <p>{{ Session::get('success') }}</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                <!-- Order Confirmation Card -->
                <div class="card mt-5 shadow-lg border-0 text-center">
                    <div class="card-body">
                        <i class="fa fa-check-circle fa-5x text-success mb-4"></i>
                        <h2 class="text-capitalize">Thank you for your order!</h2>
                        <p class="text-muted">We will contact you soon with more details.</p>
                        <hr>
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg mt-4">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
