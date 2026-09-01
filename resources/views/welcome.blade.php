<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/ecom.png') }}">
    <title>Ecommerce Website</title>
</head>
<body>
    <h1>Welcome to my Ecommerce Website</h1>
    <p>please go to admin panel using this link
    <a href="{{ route('filament.admin.auth.login') }}">Login</a>
</body>
</html>