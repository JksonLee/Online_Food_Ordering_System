

<link rel="stylesheet" href="https://bootswatch.com/4/simplex/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
  .image-container {
    position: relative;
    width: 150px;
    height: 150px;
  }

  .image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }

  .middle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .image-container:hover .middle {
    opacity: 1;
  }

  .btn-change {
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 10px;
    border: none;
  }

  .user-info h2 {
    font-size: 2rem;
    font-weight: bold;
  }

  .user-info a {
    color: #007bff;
    text-decoration: none;
  }

  .edit-profile-btn {
    margin-top: 10px;
  }

  .card {
    margin-left: -150px;
    width: 140%;
  }

  .nav-tabs {
    margin-top: 20px;
  }

  .payment-transactions {
    margin-top: 20px;
  }
</style>


@php
    use App\DesignPattern\Facade\CustomerService;

    // Create an instance of CustomerService
    $customerService = new CustomerService();

    // Get the logged-in customer's ID from session
    $customerId = Session::get('customer_id');

    // Fetch the payments using the facade
    $payments = $customerService->getCustomerPayments($customerId);
@endphp

<div class="container mt-5">
 <button onclick="window.location.href='{{ route('homepage') }}'" 
        class="btn btn-primary " style="background:blue;">
    <i class="fa fa-arrow-left"></i> Back to Homepage
</button>

    <br><br>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4 text-center">
          <div class="image-container">
            <img src="http://placehold.it/150x150" id="imgProfile" class="image img-thumbnail" />
            <div class="middle">
              <input type="button" class="btn-change" id="btnChangePicture" value="Change" />
              <input type="file" id="profilePicture" style="display: none;" />
            </div>
          </div>
          <button class="btn btn-primary edit-profile-btn" id="editProfileBtn">Edit Profile</button>
        </div>
        <div class="col-md-8 user-info">
          <h2><a href="#">{{ $customer->name }}</a></h2>
         
          <hr />
          <div class="row">
            <div class="col-sm-3 col-md-3 col-5"><strong>Full Name</strong></div>
            <div class="col-md-8 col-7">{{ $customer->name }}</div>
          </div>
          <hr />
          <div class="row">
            <div class="col-sm-3 col-md-3 col-5"><strong>Email</strong></div>
            <div class="col-md-8 col-7">{{ $customer->email }}</div>
          </div>
          <hr />
          <div class="row">
            <div class="col-sm-3 col-md-3 col-5"><strong>Phone No</strong></div>
            <div class="col-md-8 col-7">{{ $customer->phone_no }}</div>
          </div>
             <hr />
            <div class="row">
            <div class="col-sm-3 col-md-3 col-5"><strong>Password:</strong></div>
            <div class="col-md-8 col-7">{{ $customer->password }}</div> <!-- This is a static example, replace with dynamic value if required -->
          </div>
          <hr />
          <div class="row">
            <div class="col-sm-3 col-md-3 col-5"><strong>Account Created:</strong></div>
            <div class="col-md-8 col-7">{{ $customer->created_at }}</div> <!-- This is a static example, replace with dynamic value if required -->
          </div>
        </div>
      </div>

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab">Basic Info</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" id="paymentTransactions-tab" data-toggle="tab" href="#paymentTransactions" role="tab">Payment Transactions</a>
        </li>
        <li class="nav-item">
  <a class="nav-link" id="wishlist-tab" data-toggle="tab" href="#wishlist" role="tab">Wishlist</a>
</li>
        <li class="nav-item">
          <a class="nav-link" id="connectedServices-tab" data-toggle="tab" href="#connectedServices" role="tab">Connected Services</a>
        </li>
      </ul>

      <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="basicInfo" role="tabpanel">
          <!-- Basic Info already displayed next to the image -->
        </div>

          
          
<div class="tab-pane fade" id="paymentTransactions" role="tabpanel">
  <div class="payment-transactions">
    <h4>Recent Transactions</h4>
    @if($payments->count() > 0)
      <div class="list-group">
        @foreach($payments as $payment)
          <div class="list-group-item">
            <div class="d-flex justify-content-between">
              <h5 class="mb-1">Transaction ID: {{ $payment->id }}</h5>
              <a href="{{ route('view_cusinvoice', ['order_id' => $payment->order_id]) }}" class="btn btn-primary btn-sm">View Invoice</a>
            </div>
            <p class="mb-1"><strong>Order ID:</strong> {{ $payment->order_id }}</p>
            <p class="mb-1"><strong>Order Total:</strong> ${{ number_format($payment->order->order_total, 2) }}</p>
            <p class="mb-1"><strong>Payment Date:</strong> {{ $payment->created_at->format('Y-m-d') }}</p>
            <p class="mb-1"><strong>Payment Method:</strong> {{ $payment->payment_type }}</p>
            <p class="mb-1"><strong>Payment Status:</strong> {{ $payment->order_status }}</p>
          </div>
        @endforeach
      </div>
    @else
      <p class="text-center">No transactions found.</p>
    @endif
  </div>
</div>

          
          

<div class="tab-pane fade" id="wishlist" role="tabpanel">
  <h4>Your Wishlist</h4>
  @if($wishlistItems->count() > 0)
    <div class="list-group">
      @foreach($wishlistItems as $item)
        <div class="list-group-item d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
                   <img src="{{ asset($item->dish->dish_image) }}" alt="{{ $item->dish->dish_name }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover; margin-right: 15px;">
            <div>
              <h5 class="mb-1">{{ $item->dish->dish_name }}</h5>
              <p class="mb-1"><strong>Dish ID:</strong> {{ $item->dish->id }}</p>
              <p class="mb-1"><strong>Category ID:</strong> {{ $item->dish->category_id }}</p>
              <p class="mb-1"><strong>Full Price:</strong> RM{{ number_format($item->dish->full_price, 2) }}</p>
            </div>
          </div>
   <form action="{{ route('wishlist.remove') }}" method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="dish_id" value="{{ $item->dish_id }}">
            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
        </form>
        </div>
      @endforeach
    </div>
  @else
    <p class="text-center">You have no items in your wishlist.</p>
  @endif
</div>
          
        <div class="tab-pane fade" id="connectedServices" role="tabpanel">
          <p>Facebook, Google, Twitter accounts that are connected to this account.</p>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal HTML -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Success</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Item successfully removed from wishlist!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>






<script>
  $(document).ready(function () {
    const originalSrc = $('#imgProfile').attr('src');
    $('#btnChangePicture').on('click', function () {
      $('#profilePicture').click();
    });
    $('#profilePicture').on('change', function () {
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#imgProfile').attr('src', e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    });

     // Redirect to Edit Profile page when 'Edit Profile' button is clicked
  $('#editProfileBtn').on('click', function () {
    // Redirect to the Edit Profile page using window.location.href
    window.location.href = "{{ route('editprofile') }}";  // Ensure the route exists in web.php
  });
});
  
  
  $('form').on('submit', function (e) {
  e.preventDefault(); // Prevent the default form submission
  const form = $(this);

  $.ajax({
    type: form.attr('method'),
    url: form.attr('action'),
    data: form.serialize(),
    success: function () {
      $('#successModal').modal('show');
      form.closest('.list-group-item').remove(); // Remove the item from the list
    }
  });
});
  
</script>
