<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
  header("Location: nonasn.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>➕ Tambah Pegawai Non ASN</title>
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
      min-height: 100vh;
      overflow-y: auto;
    }

    html {
      overflow-x: hidden;
      scroll-behavior: smooth;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 250px;
      background: linear-gradient(to bottom, #2c3e50, #34495e);
      color: #fff;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
      overflow-y: auto;
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

    .main-content {
      margin-left: 250px;
      /* sama dengan lebar sidebar */
      flex: 1;
      padding: 40px;
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

    .btn-group {
      display: flex;
      justify-content: flex-end;
      /* tombol rata kanan */
      gap: 16px;
      /* jarak antar tombol */
      margin-top: 20px;
      margin-bottom: 10px;
      /* biar agak turun dari form */
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
    <a href="../PegawaiASN/asn.php" class="<?= basename($_SERVER['PHP_SELF']) == '../PegawaiASN/asn.php' ? 'active' : '' ?>">
      <span>👨‍💼 Pegawai ASN</span>
    </a>
    <a href="nonasn.php" class="<?= basename($_SERVER['PHP_SELF']) == 'nonasn.php' ? 'active' : '' ?>">
      <span>👷 Pegawai Non ASN</span>
    </a>
  </div>

  <div class="main-content">
    <div class="header-box">
      <h2 class="page-title">➕ Tambah Data Pegawai Non ASN</h2>
    </div>

    <div class="form-container">
      <!-- Contoh hanya bagian input form -->
      <form method="POST" action="../../proses/PegawaiNonASN/insert_nonasn.php">
        <div class="form-group">
          <label for="nama">Nama Lengkap</label>
          <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="form-group">
          <label for="nama_tanpa_gelar">Nama Tanpa Gelar</label>
          <input type="text" id="nama_tanpa_gelar" name="nama_tanpa_gelar" placeholder="Masukkan nama tanpa gelar">
        </div>

        <div class="form-group">
          <label for="nik">NIK</label>
          <input type="text" id="nik" name="nik" placeholder="Masukkan NIK">
        </div>

        <div class="form-group">
          <label for="nip">NIP</label>
          <input type="text" id="nip" name="nip" placeholder="Masukkan nip">
        </div>

        <div class="form-group">
          <label for="ruang">Ruang</label>
          <input type="text" id="ruang" name="ruang" placeholder="Masukkan nama ruang/unit kerja">
        </div>

        <div class="form-group">
          <label for="tempat_lahir">Tempat Lahir</label>
          <input type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir">
        </div>

        <div class="form-group">
          <label for="ttl">Tanggal Lahir</label>
          <input type="date" id="ttl" name="ttl" required>
        </div>

        <div class="form-group">
          <label for="agama">Agama</label>
          <select id="agama" name="agama">
            <option value="">-- Pilih Agama --</option>
            <option value="Islam">Islam</option>
            <option value="Kristen">Kristen</option>
            <option value="Katolik">Katolik</option>
            <option value="Hindu">Hindu</option>
            <option value="Buddha">Buddha</option>
            <option value="Konghucu">Konghucu</option>
            <option value="Lainnya">Lainnya</option>
          </select>
        </div>

        <div class="form-group">
          <label for="pendidikan">Pendidikan</label>
          <input type="text" id="pendidikan" name="pendidikan" placeholder="Contoh: S1, D3, SMA">
        </div>

        <div class="form-group">
          <label for="program_studi">Program Studi</label>
          <input type="text" id="program_studi" name="program_studi" placeholder="Masukkan program studi">
        </div>

        <div class="form-group">
          <label for="ijasah_terakhir">Ijasah Terakhir</label>
          <input type="text" id="ijasah_terakhir" name="ijasah_terakhir" placeholder="Contoh: S1 Teknik Informatika">
        </div>

        <div class="form-group">
          <label for="jenis_kelamin">Jenis Kelamin</label>
          <select id="jenis_kelamin" name="jenis_kelamin">
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
        </div>

        <div class="form-group">
          <label for="jabatan">Jabatan</label>
          <input type="text" id="jabatan" name="jabatan" placeholder="Masukkan nama jabatan">
        </div>

        <div class="form-group">
          <label for="rumpun_jabatan">Rumpun Jabatan</label>
          <input type="text" id="rumpun_jabatan" name="rumpun_jabatan" placeholder="Contoh: Kesehatan, Pendidikan">
        </div>

        <div class="form-group" style="grid-column: span 2;">
          <label for="alamat">Alamat</label>
          <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap"></textarea>
        </div>

        <div class="form-group">
          <label for="tmt">TMT</label>
          <input type="date" id="tmt" name="tmt">
        </div>

        <div class="form-group">
          <label for="data_bkn_non">Data BKN/Non</label>
          <select id="data_bkn_non" name="data_bkn_non" required>
            <option value="">-- Pilih Status --</option>
            <option value="BKN">BKN</option>
            <option value="NON BKN">Non BKN</option>
          </select>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select id="status" name="status" required>
            <option value="">-- Pilih Status --</option>
            <option value="Kontrak">Kontrak</option>
            <option value="Pegawai Tetap">Pegawai Tetap</option>
          </select>
        </div>

        <div class="btn-group">
          <a href="nonasn.php" class="btn-back">← Kembali</a>
          <button type="submit" class="btn-submit">💾 Simpan Data</button>
        </div>
      </form>


    </div>
  </div>
</body>

</html>