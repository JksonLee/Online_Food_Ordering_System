<!DOCTYPE html>
<html>
<head>
  <title>Reset Your Password - Num Num Food Restaurant</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
  <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
    <h2 style="color: #333333; text-align: center;">Num Num Food Restaurant</h2>
    <p style="font-size: 16px; color: #555555;">Hello,</p>
    <p style="font-size: 16px; color: #555555;">You requested to reset your password. Click the button below to reset your password:</p>
    
    <div style="text-align: center; margin: 20px 0;">
      <a href="{{ url('password/reset/'.$token) }}" style="background-color: #007bff; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-size: 16px;">Reset Password</a>
    </div>
    
    <p style="font-size: 16px; color: #555555;">If you did not request a password reset, please ignore this email.</p>
    <hr style="border: none; border-top: 1px solid #dddddd;">
    
    <p style="text-align: center; font-size: 14px; color: #777777;">
      &copy; {{ date('Y') }} Num Num Food Restaurant. All rights reserved.
    </p>
  </div>
</body>
</html>
