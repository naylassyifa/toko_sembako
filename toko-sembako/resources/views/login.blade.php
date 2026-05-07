<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

<div class="header-login">
     Aplikasi Toko Sembako Mataram - Login Admin
</div>


<div class="login-wrapper">
    <div class="login-box">

        <h2>LOGIN</h2>

        <form method="POST" action="/login">
            @csrf

            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">

            <button type="submit">Masuk</button>
        </form>

    </div>
</div>

</body>
</html>