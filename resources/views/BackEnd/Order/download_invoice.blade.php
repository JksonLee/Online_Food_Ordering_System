<!doctype html>
<html>
<head>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .header, .footer {
            text-align: center;
            padding: 10px;
        }
        .footer {
            font-size: 12px;
            color: #666;
        }
        .company-details, .client-details {
            margin-bottom: 20px;
        }
        h1 {
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        table th {
            background-color: #f2f2f2;
        }
        .total {
            text-align: right;
            padding-right: 20px;
        }
        .total strong {
            color: #333;
        }
        .invoice-details {
            margin-bottom: 20px;
            text-align: right;
        }
        .invoice-details h3 {
            margin: 0;
            font-weight: bold;
        }
        .invoice-details .date {
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>NUM NUM FOOD RESTAURANT</h1>
        </div>
        <div class="invoice-details">
            <h3>Invoice #{{$order->order_id}}</h3>
            <div class="date">Date: {{$order->created_at}}</div>
        </div>
        <div class="row">
            <div class="company-details">
                <h3>From:</h3>
                <strong>NUM NUM FOOD RESTAURANT</strong><br>
               No 29,Jalan Bunga Raya ,Negeri Sembilan,Seremban 71200<br>
                Email:num_num@gmail.com<br>
                Contract Number: 01123323738
            </div>
            <hr>
            <div class="client-details">
                <h3>To:</h3>
                <strong>{{ $shipping->name }}</strong><br>
                {{ $shipping->address }}<br>
                {{ $shipping->email }}<br>
                {{ $shipping->phone_no }}
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @php($sum = 0)
                @foreach($order_details as $orderD)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$orderD->dish_name}}</td>
                        <td>RM {{$orderD->dish_price}}</td>
                        <td>{{$orderD->dish_qty}}</td>
                        <td>RM {{ $total = $orderD->dish_price * $orderD->dish_qty }}</td>
                    </tr>
                    @php($sum += $total)
                @endforeach
            </tbody>
        </table>
        <div class="total">
            <strong>Total: RM {{$sum}}</strong>
        </div>
        <div class="footer">
            <p>NUM NUM FOOD RESTAURANT, Negeri Sembilan,Seremban 71200</p>
            <p>Thank you for your order! Please settle the payment within 14 days.</p>
        </div>
    </div>
</body>
</html>
