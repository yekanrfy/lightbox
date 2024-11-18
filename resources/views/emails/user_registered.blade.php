@extends('auth.layouts')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background: #4CAF50;
            color: #ffffff;
            padding: 10px 0;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Our Application</h1>
        </div>
        <div class="content">
            <p>Hi {{ $data['name'] }},</p>
            <p>Thank you for registering on our platform. Your registration was successful on <strong>{{ $data['registration_date'] }}</strong>.</p>
            <p>We are excited to have you on board! If you have any questions, feel free to contact us.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Our Application. All rights reserved.
        </div>
    </div>
</body>
</html>
@endsection