<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

require __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../../config/db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Buat objek spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Judul kolom
$sheet->fromArray([
  'No',
  'Nama',
  'Nama Tanpa Gelar',
  'NIK',
  'nip',
  'Ruang',
  'Tempat Lahir',
  'TTL',
  'Agama',
  'Pendidikan',
  'Program Studi',
  'Ijazah Terakhir',
  'Jenis Kelamin',
  'Jabatan',
  'Rumpun Jabatan',
  'Alamat',
  'TMT',
  'BKN/Non',
  'Status'
], null, 'A1');

// Ambil data dari database
$query = mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn");
$no = 1;
$rowIndex = 2;

while ($row = mysqli_fetch_assoc($query)) {
  $sheet->fromArray([
    $no++,
    $row['nama'],
    $row['nama_tanpa_gelar'],
    "'" . $row['nik'],
    "'" . $row['nip'],
    $row['ruang'],
    $row['tempat_lahir'],
    $row['ttl'],
    $row['agama'],
    $row['pendidikan'],
    $row['program_studi'],
    $row['ijasah_terakhir'],
    $row['jenis_kelamin'],
    $row['jabatan'],
    $row['rumpun_jabatan'],
    $row['alamat'],
    $row['tmt'],
    $row['data_bkn_non'],
    $row['status']
  ], null, 'A' . $rowIndex);
  $rowIndex++;
}

// Tentukan batas akhir kolom dan baris
$lastColumn = 'S'; // Kolom ke-19
$lastRow = $rowIndex - 1;

// Style: Bold + Center untuk header
$sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true);
$sheet->getStyle("A1:{$lastColumn}1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Style: Border tipis untuk semua sel
$sheet->getStyle("A1:{$lastColumn}{$lastRow}")
  ->getBorders()
  ->getAllBorders()
  ->setBorderStyle(Border::BORDER_THIN);

// Auto width kolom
foreach (range('A', $lastColumn) as $col) {
  $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Optional: Freeze header row
$sheet->freezePane('A2');

// Output ke browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="data_pegawai_nonasn.xlsx"');
header('Cache-Control: max-age=0');

// Simpan ke output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
