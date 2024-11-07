@extends('FrontEnd.master')

@section('title')
 Cart Show Item
@endsection

@section('content')

    <style>
        /* General Page Styling */
        .cart-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
        }
        .cart-header {
            font-size: 1.75rem;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-bottom: 2px solid #eee;
            margin-bottom: 20px;
        }
        .table-cart {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .table-cart th, .table-cart td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }
        .table-cart th {
            background-color: #f1f1f1;
            font-weight: bold;
        }
        .table-cart td img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .cart-quantity {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .cart-quantity input {
            width: 60px;
            margin-right: 10px;
            text-align: center;
            padding: 5px;
        }
        .update-btn {
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .update-btn:hover {
            background-color: #0056b3;
        }
        .remove-btn {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .remove-btn:hover {
            background-color: #c82333;
        }
       .total-section {
    text-align: right;
    margin-top: 20px;
    font-size: 1.6rem; /* Increased font size */
    padding: 15px;
    border-top: 2px solid #ddd;
    font-weight: bold; /* Added bold */
}

.total-section p {
    margin: 0;
    padding: 5px 0;
}
        .checkout-btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1.25rem;
            text-align: center;
            margin-top: 20px;
            float: right;
        }
        .checkout-btn:hover {
            background-color: #218838;
        }
    </style>

<div class="container cart-container">
     <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">
        <i class="fa fa-arrow-left"></i> Back to Menu
    </a>
    <h3 class="cart-header">Cart Item</h3>
    <table class="table-cart">
        <thead>
            <tr>
                <th>SL</th>
                <th>Remove</th>
                <th>Dish Name</th>
                <th>Dish Image</th>
                <th>Dish Price (RM)</th>
                <th>Quantity</th>
                <th>Total Price (RM)</th>
                <th>Grand Total Price (RM)</th>
            </tr>
        </thead>
        <tbody>
            @php($i = 1)
            @php($sum = 0)
            @foreach($cartItems as $dish)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        <input type="hidden" name="row_id" value="{{ $dish->rowId }}">
                        <button type="submit" class="remove-btn">&times;</button>
                    </form>
                </td>
                <td>{{ $dish->name }}</td>
                <td><img src="{{ asset($dish->options->image) }}" alt="Dish Image"></td>
                @if($dish->options->half_price == null)
            
                  <td>{{ $dish->options->half_price }}</td>
                @else
                <td>{{ $dish->price }}</td>
                @endif
                <td class="cart-quantity">
                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="row_id" value="{{ $dish->rowId }}">
                        <input type="number" name="qty" value="{{ $dish->qty }}" min="1">
                        <button type="submit" class="update-btn">Update</button>
                    </form>
                </td>
                @if($dish->options->half_price == null)
               <td>{{ $subTotal = $dish->options->half_price * $dish->qty }}</td>   
                @else
              <td>{{ $subTotal = $dish->price * $dish->qty }}</td>
                @endif
                <td>{{ $dish->subTotal }}</td>
                @php($sum += $subTotal)
            </tr>
            @endforeach
            <tr>
                <td colspan="7" class="text-right">Grand Total Price (RM):</td>
                <td class="text-center">= RM{{ $sum }}</td>
                <?php
                Session::put('sum', $sum);
                ?>
            </tr>
        </tbody>
    </table>

<div class="total-section">
    <?php
        $sum = Session::get('sum', 0); // Retrieve the sum, default to 0 if not set
        $discount = 0;  // Initialize discount to 0
        $discountedTotal = $sum; // Default to $sum in case no coupon is applied

        // Check if the cart is empty
        if ($sum > 0) {
            // Check if there is a coupon in the session
            if (Session::has('coupon')) {  // Use 'coupon' (no 's')
                $coupon = Session::get('coupon');

                // Retrieve the discount that was already calculated and stored in the session
                $discount = $coupon['discount'];

                // Apply the discount
                $discountedTotal = $sum - $discount;
            }

            // Calculate tax and total amount
            $tax = $discountedTotal * 0.06;
            $totalAmount = $discountedTotal + $tax;  // Add tax to the discounted total
        } else {
            // If cart is empty, set tax and totalAmount to 0
            $tax = 0;
            $totalAmount = 0;
        }
    ?>

    @if($sum > 0)
        <!-- Only display if cart is not empty -->
        <p>Subtotal: RM {{ number_format($sum, 2) }}</p>

        @if(Session::has('coupon')) <!-- Use 'coupon' -->
        
           <p>
    <form action="{{ route('remove.coupon') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="remove-btn">
            &times;
        </button>
    </form> Discount ({{ Session::get('coupon')['code'] }}): - RM {{ number_format($discount, 2) }}
   
</p>
            <p>New Subtotal: RM {{ number_format($discountedTotal, 2) }}</p>
        @endif

        <p>Tax (6%): RM {{ number_format($tax, 2) }}</p>
        <p>Total Amount (including tax): RM {{ number_format($totalAmount, 2) }}</p>
    @else
        <p>Your cart is empty. Please add items to your cart.</p>
    @endif
</div>



    
    
  
@if(Session::get('customer_id'))
    <div class="col-md-9 product-w3ls-right">
        <a href="{{ url('/shipping') }}" class="btn btn-info" style="float:right">
            <i class="fa fa-shopping-bag"></i>
            CheckOut
        </a>
    </div>
@else
    <div class="col-md-9 product-w3ls-right">
        <a href="" data-toggle="modal" data-target="#login_or_register" class="btn btn-info" style="float:right">
            <i class="fa fa-shopping-bag"></i>
            CheckOut
        </a>
    </div>
@endif
</div>

    
    
<!-- Modal -->
<div class="modal fade" id="login_or_register" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">x</span>
          </button>
      </div>
      <div class="modal-body">
     
          <div class="modal-body">
              <div class="col-md-6">
                  <div class="card-body">
                      <h3>
                          Welcomee...!To Staple Food
                      </h3>
                   <div class="text-center" style="
                        margin-top: 25px;
                        height:160px;
                        width:160px;
                        border-radius:50%;
                        background-color:darkblue;
                        color:ghostwhite;
                        padding-top:65px;
                        font-size:20px;
                        margin-top:65px;"> 
                       Keep your smile....
                       
                   </div>
                  </div>
              </div>
              </div>
              
          <div class="col-md-6">
              <div class="card">
                  <div class="card-body">
                      <h4>Are you a new member....!</h4>
                      <a href="{{route('sign_up')}}" class="btn-block btn-primary text-center"
                         style="
                                height:60px;
                                width:auto;
                                padding-top: 12px;
                                margin-top:25px;
                                font-size:25px;
                                ">
                          <span class="mt-5">Register</span> 
                      </a>
                      <h3 class="mt-lg-5 text-center">Or</h3>
                      <h4 class="mt-5">Already have an account....</h4>
                      <a href="{{route('login_in')}}" class="btn-block btn-success text-center"
                         style="
                         height:60px;
                         width:auto;
                         padding-top:12px;
                         margin-top:10px;
                         font-size:25px;">
                            <span class="mt-5">Login</span> 
                      </a>
                  </div>
              </div>
              
              
          </div>  
          
         </div>   
         
          
<!--     sign up-page 
    <div class="login-page about">

        <div class="loginn-agileinfo">
            <h3 class="w3ls-title w3ls-title1">Sign Up to your account</h3>
            <form action="#" method="post">
                <div class="form-group">
                    <input class="form-control" type="text" name="name" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="Your Email" required>
                </div>
                  <div class="form-group">
                    <input class="form-control" type="email" name="phone_number" placeholder="Your Phone Number" required>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <div class="wthreelogin-text">
                    <ul>
                        <li>
                            <label class="checkbox">
                                <input type="checkbox" name="checkbox">
                                <i></i>
                                <span>I agree to the terms of service</span>
                            </label>
                        </li>
                    </ul>
                </div>
                <button type="submit" class="btn btn-primary btn-block my-3">Sign Up</button>
            </form>
            <p class="text-center">Already have an account? <a href="login.html">Login Now!</a></p>
        </div>
    </div>
     sign up-page -->
          
          
          
          
     
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
    
@endsection
