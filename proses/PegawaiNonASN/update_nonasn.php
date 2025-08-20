<?php
include __DIR__ . '/../../config/db.php';

$data = $_POST;
$sql = "UPDATE pegawai_non_asn SET
  nama='{$data['nama']}',
  nama_tanpa_gelar='{$data['nama_tanpa_gelar']}',
  nik='{$data['nik']}',
  nip='{$data['nip']}',
  ruang='{$data['ruang']}',
  tempat_lahir='{$data['tempat_lahir']}',
  ttl='{$data['ttl']}',
  agama='{$data['agama']}',
  pendidikan='{$data['pendidikan']}',
  program_studi='{$data['program_studi']}',
  ijasah_terakhir='{$data['ijasah_terakhir']}',
  jenis_kelamin='{$data['jenis_kelamin']}',
  jabatan='{$data['jabatan']}',
  rumpun_jabatan='{$data['rumpun_jabatan']}',
  alamat='{$data['alamat']}',
  tmt='{$data['tmt']}',
  data_bkn_non='{$data['data_bkn_non']}',
  status='{$data['status']}'
WHERE id={$data['id']}";

mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
header("Location: ../../pages/PegawaiNonASN/nonasn.php");
exit;
