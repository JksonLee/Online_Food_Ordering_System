@extends('BackEnd.master')

@section('title')
   Category Management
@endsection

@section('content')
    <!-- Display Message -->
    @if(Session::get('sms'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ Session::get('sms') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- End Message -->

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Category Management</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Category Name</th>
                        <th>Order Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i = 1)
                    @foreach($categories as $cate)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $cate->category_name }}</td>
                            <td>{{ $cate->order_number }}</td>
                            <td>
                                @if($cate->category_status == 1)
                                    <a class="btn btn-outline-success" href="{{ route('category_deactivate', ['category_id' => $cate->category_id]) }}">
                                        <i class="fas fa-arrow-up" title="Click to Deactivate"></i>
                                    </a>
                                @else
                                    <a class="btn btn-outline-info" href="{{ route('category_activate', ['category_id' => $cate->category_id]) }}">
                                        <i class="fas fa-arrow-down" title="Click to Activate"></i>
                                    </a>
                                @endif
                                <a class="btn btn-outline-dark" data-toggle="modal" data-target="#edit{{ $cate->category_id }}">
                                    <i class="fas fa-edit" title="Click to Edit"></i>
                                </a>
                                <a class="btn btn-outline-danger" href="{{ route('category_delete', ['category_id' => $cate->category_id]) }}">
                                    <i class="fas fa-trash" title="Click to Delete"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="edit{{ $cate->category_id }}" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCategoryLabel">Update Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('category_update') }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label>Category Name</label>
                                                <input type="text" class="form-control" name="category_name" value="{{ $cate->category_name }}" required>
                                                <input type="hidden" name="category_id" value="{{ $cate->category_id }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Order Number</label>
                                                <input type="number" class="form-control" name="order_number" value="{{ $cate->order_number }}" required>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
