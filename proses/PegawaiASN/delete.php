<?php
session_start();

// Cegah user biasa mengakses
if ($_SESSION['role'] !== 'admin') {
  header("Location: ../../pages/PegawaiASN/asn.php");
  exit;
}

include __DIR__ . '/../../config/db.php';

// Validasi ID
if (isset($_GET['id'])) {
  $id = intval($_GET['id']); // amankan ID agar hanya angka
  $hapus = mysqli_query($koneksi, "DELETE FROM pegawai_asn WHERE id = $id");

  if ($hapus) {
    header("Location: ../../pages/PegawaiASN/asn.php"); // kembali ke dashboard
    exit;
  } else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
  }
} else {
  echo "ID tidak ditemukan.";
}
