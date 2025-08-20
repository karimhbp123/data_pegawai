<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
  header("Location: asn.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>➕ Tambah Pegawai ASN</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #f5f7fa;
      display: flex;
      min-height: 100vh;
      overflow: hidden;
      /* biarkan body fixed */
    }

    .main-content {
      flex: 1;
      padding: 40px;
      overflow-y: auto;
      /* ✅ konten yang bisa discroll */
      height: 100vh;
    }

    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #2c3e50, #34495e);
      color: #fff;
      padding: 20px;
      flex-shrink: 0
    }

    .sidebar h3 {
      font-size: 20px;
      margin-bottom: 20px
    }

    .sidebar a {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #bdc3c7;
      padding: 10px 14px;
      border-radius: 8px;
      margin-bottom: 10px;
      transition: 0.3s
    }

    .sidebar a:hover,
    .sidebar a.active {
      background: #1abc9c;
      color: #fff
    }


    .header-box {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      margin-bottom: 20px
    }

    h2.page-title {
      font-size: 22px;
      color: #2c3e50
    }

    .form-container {
      background: #fff;
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05)
    }

    form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px 30px
    }

    .form-group {
      display: flex;
      flex-direction: column
    }

    form label {
      font-weight: 600;
      color: #2c3e50;
      font-size: 14px;
      margin-bottom: 5px
    }

    form input,
    form select,
    form textarea {
      padding: 10px 14px;
      border: 1px solid #ccd2d8;
      border-radius: 8px;
      font-size: 14px
    }

    form input:focus,
    form select:focus,
    form textarea:focus {
      border-color: #3498db;
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
      outline: none
    }

    form textarea {
      resize: vertical;
      min-height: 90px;
      grid-column: span 2
    }

    .btn-group {
      grid-column: span 2;
      display: flex;
      justify-content: flex-start;
      gap: 15px;
      margin-top: 30px;
    }

    .btn-back,
    .btn-submit {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 12px 24px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.2s;
      border: none;
    }

    .btn-back {
      background: #e5ebf1;
      color: #2c3e50;
    }

    .btn-back:hover {
      background: #d6dde5;
    }

    .btn-submit {
      background: #2ecc71;
      color: white;
    }

    .btn-submit:hover {
      background: #27ae60;
    }

    @media(max-width:768px) {
      form {
        grid-template-columns: 1fr
      }

      .btn-group {
        flex-direction: column-reverse;
        gap: 10px
      }
    }

    a.btn-back {
      text-decoration: none !important;
      color: inherit;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h3>📊 Data Pegawai</h3>
    <a href="../dashboard.php"><span>🏠 Dashboard</span></a>
    <a href="asn.php" class="active"><span>👨‍💼 Pegawai ASN</span></a>
    <a href="../PegawaiNonASN/nonasn.php"><span>👷 Pegawai Non ASN</span></a>
  </div>

  <div class="main-content">
    <div class="header-box">
      <h2 class="page-title">➕ Tambah Data Pegawai ASN</h2>
    </div>
    <div class="form-container">
      <form method="POST" action="../../proses/PegawaiASN/insert.php">

        <!-- Data Pribadi -->
        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama" placeholder="Masukkan Nama Lengkap" required></div>
        <div class="form-group"><label>NIP</label><input type="text" name="nip" placeholder="Masukkan NIP"></div>
        <div class="form-group"><label>NIK</label><input type="text" name="nik" placeholder="Masukkan NIK"></div>
        <div class="form-group"><label>NPWP</label><input type="text" name="npwp" placeholder="Masukkan NPWP"></div>
        <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" placeholder="Masukkan Tempat Lahir"></div>
        <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="ttl"></div>
        <div class="form-group"><label>Tahun Lahir</label><input type="text" name="tahun_lahir" placeholder="Masukkan Tahun Lahir"></div>

        <!-- Data Kepegawaian -->
        <div class="form-group"><label>TMT CPNS</label><input type="date" name="tmt_cpns"></div>
        <div class="form-group"><label>Golongan Terakhir</label><input type="text" name="gol_terakhir" placeholder="Contoh: III/a"></div>
        <div class="form-group"><label>TMT Gol Terakhir</label><input type="date" name="tmt_gol_terakhir"></div>
        <div class="form-group"><label>Jabatan</label><input type="text" name="jabatan" placeholder="Masukkan Jabatan"></div>
        <div class="form-group"><label>AK Terakhir</label><input type="text" name="ak_terakhir" placeholder="Masukkan Angka Kredit Terakhir"></div>
        <div class="form-group"><label>TMT Jabatan</label><input type="date" name="tmt_jabatan"></div>
        <div class="form-group"><label>TMT Masuk</label><input type="date" name="tmt_masuk"></div>
        <div class="form-group"><label>Eselon</label><input type="text" name="eselon" placeholder="Masukkan Eselon"></div>

        <!-- Masa Kerja -->
        <div class="form-group"><label>Masa Kerja KP (Thn)</label><input type="number" name="masa_kerja_kp_thn" placeholder="Tahun"></div>
        <div class="form-group"><label>Masa Kerja KP (Bln)</label><input type="number" name="masa_kerja_kp_bln" placeholder="Bulan"></div>
        <div class="form-group"><label>Masa Kerja PNS (Thn)</label><input type="number" name="masa_kerja_pns_thn" placeholder="Tahun"></div>
        <div class="form-group"><label>Masa Kerja PNS (Bln)</label><input type="number" name="masa_kerja_pns_bln" placeholder="Bulan"></div>
        <div class="form-group"><label>Masa Kerja Gol (Thn)</label><input type="number" name="masa_kerja_gol_thn" placeholder="Tahun"></div>
        <div class="form-group"><label>Masa Kerja Gol (Bln)</label><input type="number" name="masa_kerja_gol_bln" placeholder="Bulan"></div>
        <div class="form-group"><label>Rencana KGB</label><input type="date" name="rencana_kgb"></div>
        <div class="form-group"><label>KP</label><input type="text" name="kp" placeholder="Masukkan Kenaikan Pangkat"></div>

        <!-- Usia & Pensiun -->
        <div class="form-group"><label>Usia (Thn)</label><input type="number" name="usia_thn" placeholder="Tahun"></div>
        <div class="form-group"><label>Usia (Bln)</label><input type="number" name="usia_bln" placeholder="Bulan"></div>
        <div class="form-group"><label>TMT Pensiun</label><input type="number" name="tmt_pensiun" placeholder="Tahun Pensiun"></div>

        <!-- Unit Kerja -->
        <div class="form-group"><label>Bidang</label><input type="text" name="bidang" placeholder="Masukkan Bidang"></div>
        <div class="form-group"><label>Seksi</label><input type="text" name="seksi" placeholder="Masukkan Seksi"></div>
        <div class="form-group"><label>Ruang</label><input type="text" name="ruang" placeholder="Masukkan Ruang"></div>

        <!-- Pendidikan -->
        <div class="form-group" style="grid-column:span 2;"><label>Diklat</label><textarea name="diklat" placeholder="Masukkan Riwayat Diklat"></textarea></div>
        <div class="form-group"><label>Pendidikan Terakhir</label><input type="text" name="pendidikan_terakhir" placeholder="Contoh: S1"></div>
        <div class="form-group"><label>Program Studi</label><input type="text" name="program_studi_pendidikan" placeholder="Masukkan Program Studi"></div>
        <div class="form-group"><label>Tahun Pendidikan</label><input type="text" name="tahun_pendidikan" placeholder="Tahun Lulus"></div>
        <div class="form-group"><label>Universitas</label><input type="text" name="universitas" placeholder="Masukkan Nama Universitas"></div>

        <!-- Data Lain -->
        <div class="form-group"><label>Agama</label><input type="text" name="agama" placeholder="Masukkan Agama"></div>
        <div class="form-group"><label>Status</label><input type="text" name="status" placeholder="Masukkan Status (Kawin/Belum)"></div>
        <div class="form-group"><label>Nama Suami/Istri</label><input type="text" name="nama_suami_istri" placeholder="Masukkan Nama Suami/Istri"></div>
        <div class="form-group"><label>No Akte Nikah</label><input type="text" name="no_akte" placeholder="Masukkan Nomor Akte Nikah"></div>
        <div class="form-group"><label>Tanggal Akta Nikah</label><input type="date" name="tgl_akta_nikah"></div>
        <div class="form-group" style="grid-column:span 2;"><label>Anak</label><textarea name="anak" placeholder="Masukkan Nama Anak-anak"></textarea></div>

        <!-- STR & SIP -->
        <div class="form-group"><label>STR</label><input type="text" name="str" placeholder="Masukkan Nomor STR"></div>
        <div class="form-group"><label>Tanggal STR</label><input type="date" name="tgl_str"></div>
        <div class="form-group"><label>Masa Berlaku STR</label><input type="date" name="masa_berlaku"></div>
        <div class="form-group"><label>SIP</label><input type="text" name="sip" placeholder="Masukkan Nomor SIP"></div>
        <div class="form-group"><label>Tanggal SIP</label><input type="date" name="tgl_sip"></div>

        <!-- Kontak -->
        <div class="form-group" style="grid-column:span 2;"><label>Alamat</label><textarea name="alamat" placeholder="Masukkan Alamat Lengkap"></textarea></div>
        <div class="form-group"><label>No. Telepon</label><input type="text" name="no_telp" placeholder="Masukkan Nomor Telepon"></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" placeholder="Masukkan Alamat Email"></div>
        <div class="form-group"><label>Kontak Darurat</label><input type="text" name="kontak_darurat" placeholder="Nama Kontak Darurat"></div>
        <div class="form-group"><label>Telp Darurat</label><input type="text" name="telp_darurat" placeholder="Nomor Telepon Darurat"></div>

        <div class="form-group"><label>Jenis Kelamin</label>
          <select name="jenis_kelamin">
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>

        <div class="form-group" style="grid-column:span 2;"><label>Keterangan</label><textarea name="keterangan" placeholder="Masukkan Keterangan Lain"></textarea></div>


        <!-- Tombol -->
        <div class="btn-group">
          <a href="asn.php" class="btn-back">← Kembali</a>
          <button type="submit" class="btn-submit">💾 Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>