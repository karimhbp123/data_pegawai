<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
  header("Location: ../../pages/PegawaiNonASN/nonasn.php");
  exit;
}

include '../config/db.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']); // amankan input
  $hapus = mysqli_query($koneksi, "DELETE FROM pegawai_non_asn WHERE id = $id");

  if ($hapus) {
    header("Location: ../pages/PegawaiNonASN/nonasn.php");
    exit;
  } else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
  }
} else {
  echo "ID tidak ditemukan.";
}
