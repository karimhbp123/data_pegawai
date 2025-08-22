<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

include __DIR__ . '/../../config/db.php';
require __DIR__ . '/libs/SimpleXLSXGen.php';

use Shuchkin\SimpleXLSXGen;


// Header kolom
$data = [[
  'No', 'Nama', 'NIP', 'NIK', 'NPWP', 'Tempat Lahir', 'Tanggal Lahir', 'TMT CPNS',
  'Golongan Terakhir', 'TMT Golongan Terakhir', 'Jabatan', 'Angka Kredit Terakhir',
  'TMT Jabatan', 'TMT Masuk', 'Eselon', 
  'Masa Kerja KP (Thn)', 'Masa Kerja KP (Bln)',
  'Masa Kerja PNS (Thn)', 'Masa Kerja PNS (Bln)',
  'Masa Kerja Golongan (Thn)', 'Masa Kerja Golongan (Bln)',
  'Rencana KGB', 'Kenaikan Pangkat', 
  'Usia (Thn)', 'Usia (Bln)', 'Tahun Lahir', 'TMT Pensiun',
  'Bidang', 'Seksi', 'Ruang', 'Diklat',
  'Pendidikan Terakhir', 'Program Studi', 'Tahun Pendidikan', 'Universitas',
  'Agama', 'Status', 'Nama Suami/Istri', 'No. Akte', 'Tgl. Akta Nikah',
  'Anak', 'STR', 'Tgl STR', 'Masa Berlaku STR', 
  'SIP', 'Tgl SIP',
  'Alamat', 'No Telp', 'Email', 
  'Kontak Darurat', 'Telp Darurat',
  'Jenis Kelamin', 'Keterangan'
]];

// Ambil data
$query = mysqli_query($koneksi, "SELECT * FROM pegawai_asn");
$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
  $data[] = [
    $no++,
    $row['nama'],
    $row['nip'],
    $row['nik'],
    $row['npwp'],
    $row['tempat_lahir'],
    $row['ttl'],
    $row['tmt_cpns'],
    $row['gol_terakhir'],
    $row['tmt_gol_terakhir'],
    $row['jabatan'],
    $row['ak_terakhir'],
    $row['tmt_jabatan'],
    $row['tmt_masuk'],
    $row['eselon'],
    $row['masa_kerja_kp_thn'],
    $row['masa_kerja_kp_bln'],
    $row['masa_kerja_pns_thn'],
    $row['masa_kerja_pns_bln'],
    $row['masa_kerja_gol_thn'],
    $row['masa_kerja_gol_bln'],
    $row['rencana_kgb'],
    $row['kp'],
    $row['usia_thn'],
    $row['usia_bln'],
    $row['tahun_lahir'],
    $row['tmt_pensiun'],
    $row['bidang'],
    $row['seksi'],
    $row['ruang'],
    $row['diklat'],
    $row['pendidikan_terakhir'],
    $row['program_studi_pendidikan'],
    $row['tahun_pendidikan'],
    $row['universitas'],
    $row['agama'],
    $row['status'],
    $row['nama_suami_istri'],
    $row['no_akte'],
    $row['tgl_akta_nikah'],
    $row['anak'],
    $row['str'],
    $row['tgl_str'],
    $row['masa_berlaku'],
    $row['sip'],
    $row['tgl_sip'],
    $row['alamat'],
    $row['no_telp'],
    $row['email'],
    $row['kontak_darurat'],
    $row['telp_darurat'],
    $row['jenis_kelamin'],
    $row['keterangan']
  ];
}

// Buat file Excel & download
$xlsx = SimpleXLSXGen::fromArray($data);
$xlsx->downloadAs('data_pegawai_asn.xlsx');
exit;
