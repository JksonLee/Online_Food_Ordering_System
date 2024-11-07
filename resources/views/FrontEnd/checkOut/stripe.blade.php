@extends('FrontEnd.master')

@section('title')
    Stripe | Payment
@endsection

@section('content')
<div class="products">
    <div class="container">
       <a href="{{ url()->previous() }}?sum={{ Session::get('sum') }}" class="btn btn-secondary mb-3">
    <i class="fa fa-arrow-left"></i> Back to select payment
</a>
        <div class="col-md-9 product-w3ls-right">
            <div class="card p-4 shadow-sm">
                <h1 class="card-title text-center mb-4">Thank You for Purchasing!</h1>
                <div class="card-body">
                    <hr class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header text-truncate" style="font-size:22px; background-color: #f8f9fa;">
                                    Your Order has been placed successfully!
                                </div>
                                <div class="card-body">
                                    <strong class="text-primary d-block mb-3" style="font-size:24px;">
                                        Your payable amount is 
                                        @if(Session::get('sum') == null)
                                            RM 00.00
                                        @else
                                            RM {{ Session::get('sum') }}
                                        @endif
                                    </strong>
                                    <p class="text-secondary" style="font-size:18px;">Please complete the payment using your credit or debit card below.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm p-4" style="background-color: #fafafa;">
                                <script src="https://js.stripe.com/v3/"></script>
                                <div class="card-header bg-light text-truncate" style="font-size:22px;">Enter Your Payment Details</div>
                                
                                <form role="form" action="{{ route('stripe.payment') }}" method="post" id="payment-form">
                                    @csrf
                                    <div class="form-group mt-3">
                                        <label for="name" class="form-label">Your Name</label>
                                        <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control shadow-sm">
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="amount" class="form-label">Your Amount</label>
                                        <input type="text" id="amount" name="grandTotal" value="{{ Session::get('sum') }}" placeholder="Enter your amount" class="form-control shadow-sm" readonly>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label for="card-element" class="form-label">Credit or Debit Card</label>
                                        <div id="card-element" class="form-control shadow-sm">
                                            <!-- Stripe Element will be inserted here -->
                                        </div>
                                        <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                                    </div>

                                    <button class="btn btn-primary btn-block mt-4" style="font-size:18px;">Submit Payment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var stripe = Stripe('{{env('STRIPE_KEY')}}');
    var elements = stripe.elements();

    var style = {
        base: {
            color: '#32325d',
            fontFamily: 'Helvetica, Arial, sans-serif',
            fontSize: '16px',
            '::placeholder': { color: '#aab7c4' }
        },
        invalid: { color: '#fa755a', iconColor: '#fa755a' }
    };

    var card = elements.create('card', { style: style });
    card.mount('#card-element');

    card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token);
            }
        });
    });

    function stripeTokenHandler(token) {
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        form.submit();
    }
</script>
@endsection
