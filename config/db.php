<?php
$servername = "127.0.0.1"; // host
$username = "root"; // username MySQL
$password = ""; // password MySQL
$dbname = "pegawai_db"; // nama database yang digunakan
$port = 3307;  // port yang digunakan jika bukan 3306

// Membuat koneksi
$koneksi = new mysqli($servername, $username, $password, $dbname, $port);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
