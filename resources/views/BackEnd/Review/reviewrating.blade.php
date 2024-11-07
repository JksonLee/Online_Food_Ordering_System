@extends('BackEnd.master')
@section('title')
  Review and Rating Management
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
<!-- end message -->

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Review and Rating</h3>
    </div>
    <!-- /.card-header -->
<div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SL</th>
                <th>Dish Image</th>
                <th>Dish Name</th>
                <th>Dish Price</th>
                <th>Customer Email</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Review Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @php($i = 1)
            @foreach($reviews as $review)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    @if(optional($review->dish)->dish_image)
                        <img src="{{ asset($review->dish->dish_image) }}"  height="25" width="60" class="img-fluid img-thumbnail">
                    @else
                 
                        No Image Available
                    @endif
                </td>
                <td>{{ optional($review->dish)->dish_name ?? 'No Dish Available' }}</td> <!-- Dish name from related dish -->
                <td>{{ optional($review->dish)->full_price ?? 'N/A' }}</td> <!-- Dish price from related dish -->
                <td>{{ $review->customer->email }}</td> <!-- Customer email from related customer -->
                <td>{{ $review->rating }}</td> <!-- Rating -->
                <td>{{ $review->review }}</td> <!-- Review text -->
                <td>{{ $review->created_at }}</td> <!-- Review timestamp -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <!-- /.card-body -->
</div>

@endsection
