<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: #009688;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 0 0 20px;
        }
        .content a {
            color: #009688;
            text-decoration: none;
        }
        .footer {
            background: #f4f4f4;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #777;
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to NUM NUM FOOD RESTAURANT!</h1>
        </div>
        <div class="content">
            <p>Dear <strong>{{ $name }}</strong>,</p>
            <p>Your Email Address: <strong>{{ $email }}</strong></p>
            <p>Your Phone Number: <strong>{{ $phone_no }}</strong></p>
            <p>Thank you for joining our community!</p>
            <p>Stay Connected with Us</p>
            <p>Visit this link to shop more: <a href="{{ url('/') }}">Click to shop</a></p>
            <p>Regards,</p>
            <p>The NUM NUM Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Num Num. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
