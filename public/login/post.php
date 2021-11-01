<?php 
include 'koneksi.php';

$email = mysqli_escape_string($con,$_POST['email']);
$password = mysqli_escape_string($con,$_POST['password']);

$query = mysqli_query("select * from users where username='$email' and password='$password'");
$cek = mysqli_num_rows($query);
echo $cek;
?>