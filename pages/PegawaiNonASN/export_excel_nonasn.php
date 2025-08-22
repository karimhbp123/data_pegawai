<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

include __DIR__ . '/../../config/db.php';
require __DIR__ . '/libs/SimpleXLSXGen.php';

use Shuchkin\SimpleXLSXGen;


// Ambil data dari database
$query = mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn");

// Header kolom
$data = [[
  'No','Nama','Nama Tanpa Gelar','NIK','NIP','Ruang','Tempat Lahir','TTL','Agama',
  'Pendidikan','Program Studi','Ijazah Terakhir','Jenis Kelamin','Jabatan','Rumpun Jabatan',
  'Alamat','TMT','BKN/Non','Status'
]];

$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
  $data[] = [
  $no++,
  htmlspecialchars($row['nama']),
  htmlspecialchars($row['nama_tanpa_gelar']),
  htmlspecialchars($row['nik']),
  htmlspecialchars($row['nip']),
  htmlspecialchars($row['ruang']),
  htmlspecialchars($row['tempat_lahir']),
  htmlspecialchars($row['ttl']),
  htmlspecialchars($row['agama']),
  htmlspecialchars($row['pendidikan']),
  htmlspecialchars($row['program_studi']),
  htmlspecialchars($row['ijasah_terakhir']),
  htmlspecialchars($row['jenis_kelamin']),
  htmlspecialchars($row['jabatan']),
  htmlspecialchars($row['rumpun_jabatan']),
  htmlspecialchars($row['alamat']),
  htmlspecialchars($row['tmt']),
  htmlspecialchars($row['data_bkn_non']),
  htmlspecialchars($row['status'])
];
}

// Buat file Excel & download
$xlsx = SimpleXLSXGen::fromArray($data);
$xlsx->downloadAs('data_pegawai_nonasn.xlsx');
exit;
