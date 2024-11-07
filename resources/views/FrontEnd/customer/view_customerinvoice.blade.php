<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .padding {
            padding: 20px;
        }
        .dish-image {
            max-width: 100px;
            height: auto;
        }
        .btn-print {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .btn-print:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
        <div class="card">
            <div class="card-header p-4">
                <a class="pt-2 d-inline-block" href="{{ url('/') }}" data-abc="true">NUM NUM FOOD RESTAURANT</a>
                <div class="float-right">
                    <h3 class="mb-0">Invoice #{{$order->order_id}}</h3>
                    Date: {{$order->created_at->format('d M Y')}}
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h5 class="mb-3">From:</h5>
                        <h3 class="text-dark mb-1">NUM NUM FOOD RESTAURANT</h3>
                        <div>No 29,Jalan Bunga Raya </div>
<div>Negeri Sembilan,Seremban 71200</div>
<div>Email: num_num@gmail.com</div>
<div>Contract Number: 01123323738</div>
                
                    </div>
                    <div class="col-sm-6">
                        <h5 class="mb-3">To:</h5>
                        <h3 class="text-dark mb-1">{{ $customer->name }}</h3>
                        <div>{{ $customer->address }}</div>
                        <div>{{ $customer->email }}</div>
                        <div>{{ $customer->phone_no }}</div>
                    </div>
                </div>
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Item</th>
                                <th class="right">Price</th>
                                <th class="center">Qty</th>
                                <th class="right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 1)
                            @php($sum = 0)
                            @foreach($order_details as $orderD)
                            <tr>
                                <td class="center">{{ $i++ }}</td>
                                <td class="left">
                                    @if($orderD->dish_image)
                                        <img src="{{ asset('storage/images/' . $orderD->dish_image) }}" class="dish-image" alt="{{ $orderD->dish_name }}">
                                    @endif
                                    {{ $orderD->dish_name }}
                                </td>
                                <td class="right">RM {{ $orderD->dish_price }}</td>
                                <td class="center">{{ $orderD->dish_qty }}</td>
                                <td class="right">RM {{ $total = $orderD->dish_price * $orderD->dish_qty }}</td>
                            </tr>
                            @php($sum = $sum + $total)
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5"></div>
                    <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left">
                                        <strong class="text-dark">Total</strong>
                                    </td>
                                    <td class="right">RM {{ $sum }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white">
                <p class="mb-0">NUM NUM FOOD RESTAURANT,Negeri Sembilan,Seremban 71200</p>
                <div class="mt-3">
                    <a href="javascript:window.print();" class="btn btn-print">Print Invoice</a>
                    <a href="{{ route('user_profile') }}" class="btn btn-secondary">Back to Profile</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
