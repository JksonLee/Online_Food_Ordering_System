@extends('BackEnd.master')


@section('title')
   Category Page
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
                       Category
                   </div>
                   <div class="card-body">
                       <form action="{{  route('category.save') }}" method="post">
                           @csrf
                           <div class="form-group">
                               <label>Category Name</label>
                               <input type="text" class="form-control" name="category_name" value="{{ old('category_name') }}" required>
                           </div>
                           <div class="form-group">
                               <label>Order Number</label>
                               <input type="text" class="form-control" name="order_number" value="{{ old('order_number') }}" required>
                           </div>
                           <div class="form-group">
                               <label>Added On</label>
                               <input type="date" class="form-control" name="added_on" value="{{ old('added_on') }}" required>
                           </div>
                           <div class="form-group">
                               <label>Category Status</label>
                               <div class="radio">
                                   <input type="radio" name="category_status" value="1" {{ old('category_status') == 1 ? 'checked' : '' }}> Active
                                   <input type="radio" name="category_status" value="0" {{ old('category_status') == 0 ? 'checked' : '' }}> Inactive
                               </div>
                           </div>
                           <button type="submit" class="btn btn-outline-primary btn-block">Add Category</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </div>
@endsection
