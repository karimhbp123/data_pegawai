<?php
include __DIR__ . '/../../config/db.php'; // koneksi DB

$data = $_POST;

$sql = "INSERT INTO pegawai_asn (
    nama, nip, nik, npwp, tempat_lahir, ttl, tmt_cpns, gol_terakhir, tmt_gol_terakhir, jabatan, 
    ak_terakhir, tmt_jabatan, tmt_masuk, eselon, masa_kerja_kp_thn, masa_kerja_kp_bln, 
    masa_kerja_pns_thn, masa_kerja_pns_bln, masa_kerja_gol_thn, masa_kerja_gol_bln, 
    rencana_kgb, kp, usia_thn, usia_bln, tahun_lahir, tmt_pensiun, bidang, seksi, ruang, 
    diklat, pendidikan_terakhir, program_studi_pendidikan, tahun_pendidikan, universitas, 
    agama, status, nama_suami_istri, no_akte, tgl_akta_nikah, anak, str, tgl_str, masa_berlaku, 
    sip, tgl_sip, alamat, no_telp, email, kontak_darurat, telp_darurat, jenis_kelamin, keterangan
) VALUES (
    '{$data['nama']}',
    '{$data['nip']}',
    '{$data['nik']}',
    '{$data['npwp']}',
    '{$data['tempat_lahir']}',
    '{$data['ttl']}',
    '{$data['tmt_cpns']}',
    '{$data['gol_terakhir']}',
    '{$data['tmt_gol_terakhir']}',
    '{$data['jabatan']}',
    '{$data['ak_terakhir']}',
    '{$data['tmt_jabatan']}',
    '{$data['tmt_masuk']}',
    '{$data['eselon']}',
    '{$data['masa_kerja_kp_thn']}',
    '{$data['masa_kerja_kp_bln']}',
    '{$data['masa_kerja_pns_thn']}',
    '{$data['masa_kerja_pns_bln']}',
    '{$data['masa_kerja_gol_thn']}',
    '{$data['masa_kerja_gol_bln']}',
    '{$data['rencana_kgb']}',
    '{$data['kp']}',
    '{$data['usia_thn']}',
    '{$data['usia_bln']}',
    '{$data['tahun_lahir']}',
    '{$data['tmt_pensiun']}',
    '{$data['bidang']}',
    '{$data['seksi']}',
    '{$data['ruang']}',
    '{$data['diklat']}',
    '{$data['pendidikan_terakhir']}',
    '{$data['program_studi_pendidikan']}',
    '{$data['tahun_pendidikan']}',
    '{$data['universitas']}',
    '{$data['agama']}',
    '{$data['status']}',
    '{$data['nama_suami_istri']}',
    '{$data['no_akte']}',
    '{$data['tgl_akta_nikah']}',
    '{$data['anak']}',
    '{$data['str']}',
    '{$data['tgl_str']}',
    '{$data['masa_berlaku']}',
    '{$data['sip']}',
    '{$data['tgl_sip']}',
    '{$data['alamat']}',
    '{$data['no_telp']}',
    '{$data['email']}',
    '{$data['kontak_darurat']}',
    '{$data['telp_darurat']}',
    '{$data['jenis_kelamin']}',
    '{$data['keterangan']}'
)";

mysqli_query($koneksi, $sql) or die("Query error: " . mysqli_error($koneksi));

header("Location: ../../pages/PegawaiASN/asn.php");
exit;
