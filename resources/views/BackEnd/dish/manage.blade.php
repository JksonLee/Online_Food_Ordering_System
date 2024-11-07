@extends('BackEnd.master')

@section('title')
  Dish Manage
@endsection

@section('content')

<!-- Display success message -->
@if(Session::has('sms'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ Session::get('sms') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Dish Manage</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Category Name</th>
                    <th>Dish Detail</th>
                    <th>Dish Image</th>
                    <th>Added On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach($dishes as $dish)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $dish->dish_name }}</td>
                        <td>{{ $dish->category_name }}</td>
                        <td>{{ $dish->dish_detail }}</td>
                        <td>
                            <img src="{{ asset($dish->dish_image) }}" height="25" width="60" class="img-fluid img-thumbnail">
                        </td>
                        <td>{{ $dish->created_at }}</td>
                        <td>
                            @if($dish->dish_status == 1)
                                <a class="btn btn-outline-success" href="{{ route('dish_inactive', ['dish_id' => $dish->dish_id]) }}">
                                    <i class="fas fa-arrow-up" title="Click to Inactivate"></i>
                                </a>
                            @else
                                <a class="btn btn-outline-info" href="{{ route('dish_active', ['dish_id' => $dish->dish_id]) }}">
                                    <i class="fas fa-arrow-down" title="Click to Activate"></i>
                                </a>
                            @endif
                            <a class="btn btn-outline-dark" data-toggle="modal" data-target="#edit{{$dish->dish_id}}">
                                <i class="fas fa-edit" title="Click to Edit"></i>
                            </a>
                            <a class="btn btn-outline-danger" href="{{ route('delete_dish', ['dish_id' => $dish->dish_id]) }}">
                                <i class="fas fa-trash" title="Click to Delete"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Modal for updating dish -->
                    <div class="modal fade" id="edit{{$dish->dish_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Dish Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('update_dish') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="dish_id" value="{{ $dish->dish_id }}">
                                        <div class="form-group">
                                            <label for="edit_dish_name">Name</label>
                                            <input type="text" id="edit_dish_name" class="form-control" name="dish_name" value="{{ $dish->dish_name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Previous Category</label>
                                            <input type="text" class="form-control" value="{{ $dish->category_name }}" disabled>
                                            <label for="edit_category_id">Category</label>
                                            <select id="edit_category_id" name="category_id" class="form-control" required>
                                                <option value="">------Select Category------</option>
                                                @foreach($categories as $cate)
                                                    <option value="{{ $cate->category_id }}" {{ $cate->category_id == $dish->category_id ? 'selected' : '' }}>
                                                        {{ $cate->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_dish_detail">Detail</label>
                                            <textarea id="edit_dish_detail" name="dish_detail" class="form-control" rows="5" required>{{ $dish->dish_detail }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Previous Image</label>
                                            <img src="{{ asset($dish->dish_image) }}" style="height:150px;width:150px;border-radius:50%">
                                            <input type="file" class="form-control mt-2" name="dish_image" accept="image/*">
                                        </div>
                                        <div class="card mt-3">
                                            <div class="card-header">Dish Attributes</div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="edit_full_price" class="col-md-6 col-form-label">Full Price</label>
                                                    <div class="col-md-6">
                                                        <input type="text" id="edit_full_price" class="form-control" name="full_price" value="{{ $dish->full_price }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="edit_half_price" class="col-md-6 col-form-label">Half Price</label>
                                                    <div class="col-md-6">
                                                        <input type="text" id="edit_half_price" class="form-control" name="half_price" value="{{ $dish->half_price }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <input type="submit" name="btn" class="btn btn-outline-primary btn-block" value="Update">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal End -->

                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

@endsection
