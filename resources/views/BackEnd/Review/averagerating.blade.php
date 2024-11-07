@extends('BackEnd.master')

@section('title')
  Dish Ratings Management
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
        <h3 class="card-title">Dish Ratings</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>  
                    <th>Dish ID</th>
                    <th>Dish Image</th>
                   <th>Dish Name</th>
                    <th>Average Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dishes as $dish)
                <tr>
                   <td>{{ $dish->id }}</td>
                     <td><img src="{{ asset($dish->dish_image) }}"  height="25" width="60" class="img-fluid img-thumbnail"></td>
                    <td>{{ $dish->dish_name }}</td>
                    <td>{{ number_format($dish->average_rating, 1) }}</td> <!-- Format average rating to one decimal place -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

@endsection
