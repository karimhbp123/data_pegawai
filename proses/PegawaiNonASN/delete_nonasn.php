<?php
session_start();
include '../../config/db.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn WHERE id = $id"));

if ($data) {
  // Siapkan data semua kolom
  $columns = array_keys($data);
  $columnsList = implode(',', $columns);
  $valuesList = implode("','", array_map(function ($val) use ($koneksi) {
    return mysqli_real_escape_string($koneksi, $val);
  }, array_values($data)));

  $waktu = date('Y-m-d H:i:s');

  // Simpan ke tabel terhapus + waktu
  mysqli_query($koneksi, "INSERT INTO pegawai_non_asn_terhapus ($columnsList, waktu_dihapus) VALUES ('$valuesList', '$waktu')");

  // Hapus dari tabel utama
  mysqli_query($koneksi, "DELETE FROM pegawai_non_asn WHERE id = $id");
}

header("Location: ../../pages/PegawaiNonASN/nonasn.php");
exit;
