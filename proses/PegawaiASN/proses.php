<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
  header("Location: ../../pages/PegawaiASN/asn.php");
  exit;
}

include '../config/db.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']); // amankan input
  $hapus = mysqli_query($koneksi, "DELETE FROM pegawai_asn WHERE id = $id");

  if ($hapus) {
    header("Location: ../pages/PegawaiASN/asn.php");
    exit;
  } else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
  }
} else {
  echo "ID tidak ditemukan.";
}
