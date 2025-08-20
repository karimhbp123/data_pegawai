<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../../login.php");
  exit;
}

include '../../config/db.php';

$id = intval($_GET['id']);

if ($id) {
  $query = "DELETE FROM pegawai_non_asn_terhapus WHERE id = $id";
  mysqli_query($koneksi, $query);
}

header("Location: ../../pages/PegawaiNonASN/nonasn.php?notif=hapus");
exit;
