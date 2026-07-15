<?php
session_start();
include "koneksi/koneksi.php";

if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($conn,
"SELECT * FROM admin
WHERE email='$email'
AND password='$password'");

if(mysqli_num_rows($query)>0){

$data = mysqli_fetch_assoc($query);

$_SESSION['login']=true;
$_SESSION['id_admin']=$data['id_admin'];
$_SESSION['nama']=$data['nama'];

header("Location:admin/dashboard.php");

}else{

echo "<script>
alert('Email atau Password Salah');
</script>";

}

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Login Admin</title>
<style>
    body{

margin:0;
font-family:Arial;
background:#101820;

}

.login-body{

display:flex;
justify-content:center;
align-items:center;
height:100vh;

}

.login-box{

width:350px;

background:white;

padding:40px;

border-radius:15px;

box-shadow:0 10px 30px rgba(0,0,0,.4);

text-align:center;

}

.login-box h1{

margin-bottom:30px;

color:#5d3fd3;

}

.login-box input{

width:100%;

padding:13px;

margin:10px 0;

border:1px solid #ddd;

border-radius:8px;

}

.login-box button{

width:100%;

padding:14px;

background:#6a4cff;

border:none;

color:white;

font-size:18px;

border-radius:8px;

cursor:pointer;

}

.login-box button:hover{

background:#5537dd;

}
</style>
</head>

<body class="login-body">

<div class="login-box">

<h1>SMART EVENT</h1>

<form method="POST">

<input
type="email"
name="email"
placeholder="Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button name="login">

LOGIN

</button>

</form>

</div>

</body>

</html>