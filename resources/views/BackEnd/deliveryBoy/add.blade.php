@extends('BackEnd.master')
@section('title')
  Delivery Boy Add
   @endsection

   @section('content')
   
   <div class="container">
    <div class="row">
        <div class="offset-3 col-md-5">
            @if(Session::get('sms'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>{{ Session::get('sms') }}</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>
       @endif
            
            
       <div class="card">
             <div class="card-header text-center">
                   Delivery Boy
                </div>
                <div class="card-body">
                    <form action=" {{route('delivery_save')}} " method="post">
                     @csrf
                        <div class="form-group">
                            <label> Name</label>
                            <input type="text" class="form-control" name="delivery_boy_name">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="delivery_boy_phone_number">
                        </div>
                      <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="delivery_boy_password">
                        </div>
                        <div class="form-group">
                            <label>Added On</label>
                            <input type="date" class="form-control" name="added_on">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="radio">
                                <input type="radio" name="delivery_boy_status" value="1"> Active
                                <input type="radio" name="delivery_boy_status" value="0"> Inactive
                            </div>
                        </div>
                        <button type="submit" name="btn" class="btn btn-outline-primary btn-block">DeliveryBoy Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

   @endsection