<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "smart_event_campus";

$conn = mysqli_connect( $host, $username, $password, $db);

if(!$conn){
   die("Gagal connect: ".mysqli_connect_error());
}



?>