<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-5">
   <div class="card">
    <div class="card-body">
      <div class="row">
        <!-- Left Column: Profile Image -->
        <div class="col-md-4 text-center">
          <div class="image-container">
            <img src="http://placehold.it/150x150" id="imgProfile" class="image img-thumbnail rounded-circle" alt="Profile Picture" />
            <div class="middle">
              <input type="button" class="btn btn-primary mt-3" id="btnChangePicture" value="Change Picture" />
              <input type="file" id="profilePicture" style="display: none;" />
            </div>
          </div>
        </div>

        <!-- Right Column: Form for Editing Profile Information -->
        <div class="col-md-8">
          <h2 class="mb-3">Edit Profile</h2>
          @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
          <form action="{{ route('customer.updateProfile') }}" method="POST">
            @csrf

            <!-- Full Name -->
            <div class="form-group">
              <label for="fullName">Full Name</label>
              <input type="text" class="form-control" id="fullName" name="fullName" value="{{ $customer->name }}" placeholder="Enter your full name">
            </div>

            <!-- Email -->
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" placeholder="Enter your email">
            </div>

            <!-- Phone Number -->
            <div class="form-group">
              <label for="phone">Phone No</label>
              <input type="text" class="form-control" id="phone" name="phone" value="{{ $customer->phone_no }}" placeholder="Enter your phone number">
            </div>

            <!-- Password -->
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password"   placeholder="Enter new password if changing">
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
              <label for="confirmPassword">Confirm Password</label>
              <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password">
            </div>

            <!-- Show Password Checkbox -->
            <div class="form-group">
              <input type="checkbox" id="showPassword"> Show Password
            </div>

            <!-- Save Changes Button -->
            <div class="form-group text-right">
              <button type="submit" class="btn btn-success">Save Changes</button>
              <a href="{{ route('user_profile') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript to handle profile picture change and show/hide password -->
<script>
  $(document).ready(function () {
    // Profile picture change
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

    // Toggle Password Visibility
    $('#showPassword').on('click', function () {
      const passwordField = $('#password');
      const confirmPasswordField = $('#confirmPassword');
      const passwordFieldType = passwordField.attr('type') === 'password' ? 'text' : 'password';
      
      passwordField.attr('type', passwordFieldType);
      confirmPasswordField.attr('type', passwordFieldType);
    });
  });
</script>
