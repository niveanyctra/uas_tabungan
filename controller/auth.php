<?php
include "../config.php";
$username = $_POST['username'];
$password = $_POST['password'];
$query = mysqli_query($conn, "select * from users where username = '$username' && password = '$password'");
$check = mysqli_num_rows($query);

if ($check > 0) {
    session_start();
    $_SESSION['username'] = $username;
    header("location:../index.php");
} else {
    header("location:../pages/auth/login.php?pesan=gagal");
}
