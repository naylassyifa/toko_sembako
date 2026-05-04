<?php
session_start();
include 'koneksi.php';

$error = "";

if(isset($_POST['login'])){
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    $cek = mysqli_query($conn,
        "SELECT * FROM admin WHERE username='$user' AND password='$pass'"
    );

    if(mysqli_num_rows($cek) > 0){
    $_SESSION['login'] = true;

    $data = mysqli_fetch_assoc($cek);
    $_SESSION['user'] = $data['username']; // INI PENTING

    header("location:index.php");
    exit;
}   
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Admin</title>
<link rel="stylesheet" href="style.css">

<style>
body{
    font-family: Arial;
    background:#f4f6f9;
    margin:0;
}

/* HEADER SAMA KAYA INDEX */
.header{
    background:#2d3436;
    color:white;
    padding:15px;
    text-align:center;
    font-size:20px;
}

/* CARD LOGIN */
.login-box{
    width:300px;
    background:white;
    margin:80px auto;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

input{
    width:100%;
    padding:10px;
    margin-top:10px;
    margin-bottom:10px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    width:100%;
    padding:10px;
    background:#0984e3;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#74b9ff;
}

.error{
    background:#ff7675;
    color:white;
    padding:8px;
    border-radius:5px;
    margin-bottom:10px;
    text-align:center;
}
</style>
</head>

<body>

<div class="header">
    🛒 Aplikasi Toko Sembako - Login Admin
</div>

<div class="login-box">

    <h3 style="text-align:center;">LOGIN</h3>

    <?php if($error != "") { ?>
        <div class="error"><?= $error; ?></div>
    <?php } ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">

        <button type="submit" name="login">Masuk</button>
    </form>

</div>

</body>
</html>