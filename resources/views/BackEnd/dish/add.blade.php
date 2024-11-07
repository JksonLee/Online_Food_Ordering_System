@extends('BackEnd.master')
@section('title')
  Add Dish
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="offset-3 col-md-6">
            @if(Session::has('sms'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('sms') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="card">
                <div class="card-header text-center">
                    Add Dish
                </div>
                <div class="card-body">
                    <form action="{{ route('save_dish_data') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="dish_name">Name</label>
                            <input type="text" id="dish_name" class="form-control" name="dish_name" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" name="category_id" class="form-control" required>
                                <option value="">------Select Category------</option>
                                @foreach($categories as $cate)
                                  <option value="{{ $cate->category_id }}">{{ $cate->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dish_detail">Detail</label>
                            <textarea id="dish_detail" name="dish_detail" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="dish_image">Image</label>
                            <input type="file" id="dish_image" class="form-control" name="dish_image" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="form-check">
                                <input type="radio" id="status_active" name="dish_status" value="1" class="form-check-input" checked>
                                <label for="status_active" class="form-check-label">Active</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="status_inactive" name="dish_status" value="0" class="form-check-input">
                                <label for="status_inactive" class="form-check-label">Inactive</label>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header" title="You can skip this">Dish Attributes</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="full_price" class="col-md-6 col-form-label">Full Price</label>
                                    <div class="col-md-6">
                                        <input type="text" id="full_price" class="form-control" name="full_price" placeholder="Enter Price">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="half_price" class="col-md-6 col-form-label">Half Price</label>
                                    <div class="col-md-6">
                                        <input type="text" id="half_price" class="form-control" name="half_price" placeholder="Enter 2nd Price">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="btn" class="btn btn-outline-primary btn-block mt-3">Add Dish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
