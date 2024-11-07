@extends('BackEnd.master')
@section('title')
  Coupon Manage
@endsection
@section('content')

<!-- For display message -->
@if(Session::get('sms'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>{{ Session::get('sms') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<!-- End message -->

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Coupon Manage</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Cart Min</th>
                    <th>Expired On</th>
                    <th>Added On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach($coupons as $coupon)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $coupon->coupon_code }}</td>
                    <td>
                        @if($coupon->coupon_type == 1)
                        Percentage
                        @else
                        Fixed
                        @endif
                    </td>
                    <td>{{ $coupon->coupon_value }}</td>
                    <td>{{ $coupon->cart_min_value }}</td>
                    <td>{{ $coupon->expired_on }}</td>
                    <td>{{ $coupon->added_on }}</td>
                    <td>
                        @if($coupon->coupon_status == 1)
                        <a class="btn btn-outline-success" href="{{ route('coupon_deactivate', ['coupon_id' => $coupon->coupon_id]) }}">
                            <i class="fas fa-arrow-up" title="Click to Inactivate"></i>
                        </a>
                        @else
                        <a class="btn btn-outline-info" href="{{ route('coupon_activate', ['coupon_id' => $coupon->coupon_id]) }}">
                            <i class="fas fa-arrow-down" title="Click to Activate"></i>
                        </a>
                        @endif
                        <a type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#edit{{ $coupon->coupon_id }}">
                            <i class="fas fa-edit" title="Click to Edit"></i>
                        </a>
                        <a class="btn btn-outline-danger" href="{{ route('coupon_delete', ['coupon_id' => $coupon->coupon_id]) }}">
                            <i class="fas fa-trash" title="Click to Delete"></i>
                        </a>
                    </td>
                </tr>

                <!-- Modal for editing coupon -->
                <div class="modal fade" id="edit{{ $coupon->coupon_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Coupon</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('coupon_update') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input type="text" class="form-control" name="coupon_code" value="{{ $coupon->coupon_code }}">
                                        <input type="hidden" class="form-control" name="coupon_id" value="{{ $coupon->coupon_id }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Coupon Value</label>
                                        <input type="number" class="form-control" name="coupon_value" value="{{ $coupon->coupon_value }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Cart Min Value</label>
                                        <input type="number" class="form-control" name="cart_min_value" value="{{ $coupon->cart_min_value }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Select Coupon Type</label>
                                        <div class="radio">
                                            <input type="radio" name="coupon_type" value="1" {{ $coupon->coupon_type == 1 ? 'checked' : '' }}> Percentage
                                            <input type="radio" name="coupon_type" value="0" {{ $coupon->coupon_type == 0 ? 'checked' : '' }}> Fixed
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="btn" class="btn btn-primary" value="Update">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End modal -->

                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection
