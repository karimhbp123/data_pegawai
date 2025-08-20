<?php
session_start();
include '../config/db.php';

$user = $_POST['username'];
$pass = md5($_POST['password']);

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
$data = mysqli_fetch_assoc($query);

if ($data) {
  $_SESSION['login'] = true;
  $_SESSION['username'] = $data['username'];
  $_SESSION['role'] = $data['role'];
  header("Location:../pages/dashboard.php");
} else {
  echo "Login gagal!";
}
