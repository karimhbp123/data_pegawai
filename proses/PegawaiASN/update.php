<?php
include __DIR__ . '/../../config/db.php';

$data = $_POST;

$sql = "UPDATE pegawai_asn SET
  nama='{$data['nama']}',
  nip='{$data['nip']}',
  nik='{$data['nik']}',
  npwp='{$data['npwp']}',
  tempat_lahir='{$data['tempat_lahir']}',
  ttl='{$data['ttl']}',
  tmt_cpns='{$data['tmt_cpns']}',
  gol_terakhir='{$data['gol_terakhir']}',
  tmt_gol_terakhir='{$data['tmt_gol_terakhir']}',
  jabatan='{$data['jabatan']}',
  ak_terakhir='{$data['ak_terakhir']}',
  tmt_jabatan='{$data['tmt_jabatan']}',
  tmt_masuk='{$data['tmt_masuk']}',
  eselon='{$data['eselon']}',
  masa_kerja_kp_thn='{$data['masa_kerja_kp_thn']}',
  masa_kerja_kp_bln='{$data['masa_kerja_kp_bln']}',
  masa_kerja_pns_thn='{$data['masa_kerja_pns_thn']}',
  masa_kerja_pns_bln='{$data['masa_kerja_pns_bln']}',
  masa_kerja_gol_thn='{$data['masa_kerja_gol_thn']}',
  masa_kerja_gol_bln='{$data['masa_kerja_gol_bln']}',
  rencana_kgb='{$data['rencana_kgb']}',
  kp='{$data['kp']}',
  usia_thn='{$data['usia_thn']}',
  usia_bln='{$data['usia_bln']}',
  tahun_lahir='{$data['tahun_lahir']}',
  tmt_pensiun='{$data['tmt_pensiun']}',
  bidang='{$data['bidang']}',
  seksi='{$data['seksi']}',
  ruang='{$data['ruang']}',
  diklat='{$data['diklat']}',
  pendidikan_terakhir='{$data['pendidikan_terakhir']}',
  program_studi_pendidikan='{$data['program_studi_pendidikan']}',
  tahun_pendidikan='{$data['tahun_pendidikan']}',
  universitas='{$data['universitas']}',
  agama='{$data['agama']}',
  status='{$data['status']}',
  nama_suami_istri='{$data['nama_suami_istri']}',
  no_akte='{$data['no_akte']}',
  tgl_akta_nikah='{$data['tgl_akta_nikah']}',
  anak='{$data['anak']}',
  str='{$data['str']}',
  tgl_str='{$data['tgl_str']}',
  masa_berlaku='{$data['masa_berlaku']}',
  sip='{$data['sip']}',
  tgl_sip='{$data['tgl_sip']}',
  alamat='{$data['alamat']}',
  no_telp='{$data['no_telp']}',
  email='{$data['email']}',
  kontak_darurat='{$data['kontak_darurat']}',
  telp_darurat='{$data['telp_darurat']}',
  jenis_kelamin='{$data['jenis_kelamin']}',
  keterangan='{$data['keterangan']}'
WHERE id={$data['id']}";

mysqli_query($koneksi, $sql) or die("Query error: " . mysqli_error($koneksi));
header("Location: ../../pages/PegawaiASN/asn.php");
exit;
