<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RGUWB Shop</title>
</head>
<body>
    <h3>Form: {{ $name }}</h3>
    <h4>Verification Code</h4>
    <h5>Here is your verification code: <span> {{ $body }}</span></h5>
    <h5>Valid for five minutes</h5>
    <h4>If you didn't request this code, you can safely ignore this email. Someone else might have typed your email address by mistake.</h4>
</body>
</html>
