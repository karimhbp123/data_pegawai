<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
  header("Location: asn.php");
  exit;
}
include __DIR__ . '/../../config/db.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pegawai_asn WHERE id = $id"));
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>✏️ Edit Pegawai</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
body {
  font-family: 'Inter', sans-serif;
  background: #f5f7fa;
  display: flex;
  min-height: 100vh;
  overflow: hidden; /* biarkan body fixed */
}

.main-content {
  flex: 1;
  padding: 40px;
  overflow-y: auto;   /* ✅ konten yang bisa discroll */
  height: 100vh;
}

    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #2c3e50, #34495e);
      color: #fff;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
      flex-shrink: 0;
    }

    .sidebar h3 {
      font-size: 20px;
      color: #ecf0f1;
      margin-bottom: 20px;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #bdc3c7;
      font-weight: 500;
      padding: 10px 14px;
      border-radius: 8px;
      transition: background 0.3s, color 0.3s;
      margin-bottom: 10px;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #1abc9c;
      color: white;
    }

    .sidebar a span {
      display: inline-block;
      width: 100%;
    }


    .header-box {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      margin-bottom: 20px;
    }

    h2.page-title {
      font-size: 22px;
      color: #2c3e50;
      margin: 0;
    }

    .form-container {
      background-color: #ffffff;
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px 30px;
    }

    form label {
      font-weight: 600;
      color: #2c3e50;
      font-size: 14px;
      margin-bottom: 5px;
      display: block;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    form input,
    form select,
    form textarea {
      padding: 10px 14px;
      border: 1px solid #ccd2d8;
      border-radius: 8px;
      font-size: 14px;
      background-color: #fff;
      transition: border 0.3s, box-shadow 0.3s;
    }

    form input:focus,
    form select:focus,
    form textarea:focus {
      border-color: #3498db;
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
      outline: none;
    }

    form textarea {
      resize: vertical;
      min-height: 90px;
      grid-column: span 2;
    }

    btn-group {
      grid-column: span 2;
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }

    .btn-back,
    .btn-submit {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: none;
      padding: 12px 24px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-back {
      background-color: #e0e6ed;
      color: #2c3e50;
    }

    .btn-back:hover {
      background-color: #d0dae3;
    }

    .btn-submit {
      background-color: #2ecc71;
      color: #fff;
    }

    .btn-submit:hover {
      background-color: #27ae60;
    }

    @media (max-width: 768px) {
      form {
        grid-template-columns: 1fr;
      }

      form textarea {
        grid-column: span 1;
      }

      .btn-group {
        flex-direction: column-reverse;
        gap: 10px;
        align-items: stretch;
      }
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h3>📊 Data Pegawai</h3>
    <a href="../dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == '../dashboard.php' ? 'active' : '' ?>">
      <span>🏠 Dashboard</span>
    </a>
    <a href="asn.php" class="<?= basename($_SERVER['PHP_SELF']) == 'asn.php' ? 'active' : '' ?>">
      <span>👨‍💼 Pegawai ASN</span>
    </a>
    <a href="PegawaiNonASN/nonasn.php" class="<?= basename($_SERVER['PHP_SELF']) == 'PegawaiNonASN/nonasn.php' ? 'active' : '' ?>">
      <span>👷 Pegawai Non ASN</span>
    </a>
  </div>
  <div class="main-content">
    <div class="header-box">
      <h2 class="page-title">✏️ Edit Data Pegawai ASN</h2>
    </div>
    <div class="form-container">
     <form method="POST" action="../../proses/PegawaiASN/update.php">
  <input type="hidden" name="id" value="<?= $data['id'] ?>">

  <!-- Data Pribadi -->
  <div class="form-group">
    <label>Nama Lengkap</label>
    <input type="text" name="nama" value="<?= $data['nama'] ?>">
  </div>
  <div class="form-group">
    <label>NIP</label>
    <input type="text" name="nip" value="<?= $data['nip'] ?>">
  </div>
  <div class="form-group">
    <label>NIK</label>
    <input type="text" name="nik" value="<?= $data['nik'] ?>">
  </div>
  <div class="form-group">
    <label>NPWP</label>
    <input type="text" name="npwp" value="<?= $data['npwp'] ?>">
  </div>
  <div class="form-group">
    <label>Tempat Lahir</label>
    <input type="text" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>">
  </div>
  <div class="form-group">
    <label>Tanggal Lahir</label>
    <input type="date" name="ttl" value="<?= $data['ttl'] ?>">
  </div>
  <div class="form-group">
    <label>Tahun Lahir</label>
    <input type="text" name="tahun_lahir" value="<?= $data['tahun_lahir'] ?>">
  </div>

  <!-- Data Kepegawaian -->
  <div class="form-group">
    <label>TMT CPNS</label>
    <input type="date" name="tmt_cpns" value="<?= $data['tmt_cpns'] ?>">
  </div>
  <div class="form-group">
    <label>Golongan Terakhir</label>
    <input type="text" name="gol_terakhir" value="<?= $data['gol_terakhir'] ?>">
  </div>
  <div class="form-group">
    <label>TMT Gol Terakhir</label>
    <input type="date" name="tmt_gol_terakhir" value="<?= $data['tmt_gol_terakhir'] ?>">
  </div>
  <div class="form-group">
    <label>Jabatan</label>
    <input type="text" name="jabatan" value="<?= $data['jabatan'] ?>">
  </div>
  <div class="form-group">
    <label>AK Terakhir</label>
    <input type="text" name="ak_terakhir" value="<?= $data['ak_terakhir'] ?>">
  </div>
  <div class="form-group">
    <label>TMT Jabatan</label>
    <input type="date" name="tmt_jabatan" value="<?= $data['tmt_jabatan'] ?>">
  </div>
  <div class="form-group">
    <label>TMT Masuk</label>
    <input type="date" name="tmt_masuk" value="<?= $data['tmt_masuk'] ?>">
  </div>
  <div class="form-group">
    <label>Eselon</label>
    <input type="text" name="eselon" value="<?= $data['eselon'] ?>">
  </div>

  <!-- Masa Kerja -->
  <div class="form-group">
    <label>Masa Kerja KP (Thn)</label>
    <input type="number" name="masa_kerja_kp_thn" value="<?= $data['masa_kerja_kp_thn'] ?>">
  </div>
  <div class="form-group">
    <label>Masa Kerja KP (Bln)</label>
    <input type="number" name="masa_kerja_kp_bln" value="<?= $data['masa_kerja_kp_bln'] ?>">
  </div>
  <div class="form-group">
    <label>Masa Kerja PNS (Thn)</label>
    <input type="number" name="masa_kerja_pns_thn" value="<?= $data['masa_kerja_pns_thn'] ?>">
  </div>
  <div class="form-group">
    <label>Masa Kerja PNS (Bln)</label>
    <input type="number" name="masa_kerja_pns_bln" value="<?= $data['masa_kerja_pns_bln'] ?>">
  </div>
  <div class="form-group">
    <label>Masa Kerja Gol (Thn)</label>
    <input type="number" name="masa_kerja_gol_thn" value="<?= $data['masa_kerja_gol_thn'] ?>">
  </div>
  <div class="form-group">
    <label>Masa Kerja Gol (Bln)</label>
    <input type="number" name="masa_kerja_gol_bln" value="<?= $data['masa_kerja_gol_bln'] ?>">
  </div>

  <div class="form-group">
    <label>Rencana KGB</label>
    <input type="date" name="rencana_kgb" value="<?= $data['rencana_kgb'] ?>">
  </div>
  <div class="form-group">
    <label>KP</label>
    <input type="text" name="kp" value="<?= $data['kp'] ?>">
  </div>

  <!-- Usia & Pensiun -->
  <div class="form-group">
    <label>Usia (Thn)</label>
    <input type="number" name="usia_thn" value="<?= $data['usia_thn'] ?>">
  </div>
  <div class="form-group">
    <label>Usia (Bln)</label>
    <input type="number" name="usia_bln" value="<?= $data['usia_bln'] ?>">
  </div>
  <div class="form-group">
    <label>TMT Pensiun</label>
    <input type="number" name="tmt_pensiun" value="<?= $data['tmt_pensiun'] ?>">
  </div>

  <!-- Unit Kerja -->
  <div class="form-group">
    <label>Bidang</label>
    <input type="text" name="bidang" value="<?= $data['bidang'] ?>">
  </div>
  <div class="form-group">
    <label>Seksi</label>
    <input type="text" name="seksi" value="<?= $data['seksi'] ?>">
  </div>
  <div class="form-group">
    <label>Ruang</label>
    <input type="text" name="ruang" value="<?= $data['ruang'] ?>">
  </div>

  <!-- Pendidikan -->
  <div class="form-group" style="grid-column: span 2;">
    <label>Diklat</label>
    <textarea name="diklat"><?= $data['diklat'] ?></textarea>
  </div>
  <div class="form-group">
    <label>Pendidikan Terakhir</label>
    <input type="text" name="pendidikan_terakhir" value="<?= $data['pendidikan_terakhir'] ?>">
  </div>
  <div class="form-group">
    <label>Program Studi</label>
    <input type="text" name="program_studi_pendidikan" value="<?= $data['program_studi_pendidikan'] ?>">
  </div>
  <div class="form-group">
    <label>Tahun Pendidikan</label>
    <input type="text" name="tahun_pendidikan" value="<?= $data['tahun_pendidikan'] ?>">
  </div>
  <div class="form-group">
    <label>Universitas</label>
    <input type="text" name="universitas" value="<?= $data['universitas'] ?>">
  </div>

  <!-- Data Lain -->
  <div class="form-group">
    <label>Agama</label>
    <input type="text" name="agama" value="<?= $data['agama'] ?>">
  </div>
  <div class="form-group">
    <label>Status</label>
    <input type="text" name="status" value="<?= $data['status'] ?>">
  </div>
  <div class="form-group">
    <label>Nama Suami/Istri</label>
    <input type="text" name="nama_suami_istri" value="<?= $data['nama_suami_istri'] ?>">
  </div>
  <div class="form-group">
    <label>No Akte Nikah</label>
    <input type="text" name="no_akte" value="<?= $data['no_akte'] ?>">
  </div>
  <div class="form-group">
    <label>Tanggal Akta Nikah</label>
    <input type="date" name="tgl_akta_nikah" value="<?= $data['tgl_akta_nikah'] ?>">
  </div>
  <div class="form-group" style="grid-column: span 2;">
    <label>Anak</label>
    <textarea name="anak"><?= $data['anak'] ?></textarea>
  </div>

  <!-- STR & SIP -->
  <div class="form-group">
    <label>STR</label>
    <input type="text" name="str" value="<?= $data['str'] ?>">
  </div>
  <div class="form-group">
    <label>Tanggal STR</label>
    <input type="date" name="tgl_str" value="<?= $data['tgl_str'] ?>">
  </div>
  <div class="form-group">
    <label>Masa Berlaku STR</label>
    <input type="date" name="masa_berlaku" value="<?= $data['masa_berlaku'] ?>">
  </div>
  <div class="form-group">
    <label>SIP</label>
    <input type="text" name="sip" value="<?= $data['sip'] ?>">
  </div>
  <div class="form-group">
    <label>Tanggal SIP</label>
    <input type="date" name="tgl_sip" value="<?= $data['tgl_sip'] ?>">
  </div>

  <!-- Kontak -->
  <div class="form-group" style="grid-column: span 2;">
    <label>Alamat</label>
    <textarea name="alamat"><?= $data['alamat'] ?></textarea>
  </div>
  <div class="form-group">
    <label>No. Telepon</label>
    <input type="text" name="no_telp" value="<?= $data['no_telp'] ?>">
  </div>
  <div class="form-group">
    <label>Email</label>
    <input type="email" name="email" value="<?= $data['email'] ?>">
  </div>
  <div class="form-group">
    <label>Kontak Darurat</label>
    <input type="text" name="kontak_darurat" value="<?= $data['kontak_darurat'] ?>">
  </div>
  <div class="form-group">
    <label>Telp Darurat</label>
    <input type="text" name="telp_darurat" value="<?= $data['telp_darurat'] ?>">
  </div>

  <div class="form-group">
    <label>Jenis Kelamin</label>
    <select name="jenis_kelamin">
      <option value="">-- Pilih --</option>
      <option value="Laki-laki" <?= $data['jenis_kelamin']=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
      <option value="Perempuan" <?= $data['jenis_kelamin']=='Perempuan'?'selected':'' ?>>Perempuan</option>
    </select>
  </div>

  <div class="form-group" style="grid-column: span 2;">
    <label>Keterangan</label>
    <textarea name="keterangan"><?= $data['keterangan'] ?></textarea>
  </div>

  <!-- Tombol -->
  <div class="btn-group">
    <a href="asn.php" class="btn-back">← Kembali</a>
    <button type="submit" class="btn-submit">💾 Simpan Perubahan</button>
  </div>
</form>

    </div>
  </div>
</body>

</html>