<?php
include __DIR__ . '/../../config/db.php'; // naik 2 folder ke atas untuk akses db.php

$data = $_POST;

$sql = "INSERT INTO pegawai_non_asn (
  nama,
  nama_tanpa_gelar,
  nik,
  nip,
  ruang,
  tempat_lahir,
  ttl,
  agama,
  pendidikan,
  program_studi,
  ijasah_terakhir,
  jenis_kelamin,
  jabatan,
  rumpun_jabatan,
  alamat,
  tmt,
  data_bkn_non,
  status
) VALUES (
  '{$data['nama']}',
  '{$data['nama_tanpa_gelar']}',
  '{$data['nik']}',
  '{$data['nip']}',
  '{$data['ruang']}',
  '{$data['tempat_lahir']}',
  '{$data['ttl']}',
  '{$data['agama']}',
  '{$data['pendidikan']}',
  '{$data['program_studi']}',
  '{$data['ijasah_terakhir']}',
  '{$data['jenis_kelamin']}',
  '{$data['jabatan']}',
  '{$data['rumpun_jabatan']}',
  '{$data['alamat']}',
  '{$data['tmt']}',
  '{$data['data_bkn_non']}',
  '{$data['status']}'
)";

mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
header("Location: ../../pages/PegawaiNonASN/nonasn.php");
exit;
