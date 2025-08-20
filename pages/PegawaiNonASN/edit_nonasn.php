<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
  header("Location: nonasn.php");
  exit;
}
include __DIR__ . '/../../config/db.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn WHERE id = $id"));
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>✏️ Edit Pegawai Non ASN</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* Sama seperti file tambah, langsung salin dari CSS kamu sebelumnya */
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
      gap: 16px;
      margin-top: 20px;
      margin-bottom: 10px;
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
    <a href="../dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == '../dashboard.php' ? 'active' : '' ?>"><span>🏠 Dashboard</span></a>
    <a href="../PegawaiASN/asn.php" class=""><span>👨‍💼 Pegawai ASN</span></a>
    <a href="nonasn.php" class="active"><span>👷 Pegawai Non ASN</span></a>
  </div>

  <div class="main-content">
    <div class="header-box">
      <h2 class="page-title">✏️ Edit Data Pegawai Non ASN</h2>
    </div>

    <div class="form-container">
      <form method="POST" action="../../proses/PegawaiNonASN/update_nonasn.php">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <?php
        function selected($val, $target)
        {
          return trim(strtoupper($val)) === trim(strtoupper($target)) ? 'selected' : '';
        }
        ?>

        <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama" value="<?= $data['nama'] ?>"></div>
        <div class="form-group"><label>Nama Tanpa Gelar</label><input type="text" name="nama_tanpa_gelar" value="<?= $data['nama_tanpa_gelar'] ?>"></div>
        <div class="form-group"><label>NIK</label><input type="text" name="nik" value="<?= $data['nik'] ?>"></div>
        <div class="form-group"><label>NIP</label><input type="text" name="nip" value="<?= $data['nip'] ?>"></div>
        <div class="form-group"><label>Ruang</label><input type="text" name="ruang" value="<?= $data['ruang'] ?>"></div>
        <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>"></div>
        <div class="form-group">
          <label for="ttl">Tanggal Lahir</label>
          <input type="date" id="ttl" name="ttl" required value="<?= $data['ttl'] ?>">
        </div>
        <div class="form-group">
          <label>Agama</label>
          <select name="agama">
            <option value="">-- Pilih Agama --</option>
            <?php
            $agama_list = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'];
            foreach ($agama_list as $agama) {
              echo "<option value='$agama' " . selected($data['agama'], $agama) . ">$agama</option>";
            }
            ?>
          </select>
        </div>
        <div class="form-group"><label>Pendidikan</label><input type="text" name="pendidikan" value="<?= $data['pendidikan'] ?>"></div>
        <div class="form-group"><label>Program Studi</label><input type="text" name="program_studi" value="<?= $data['program_studi'] ?>"></div>
        <div class="form-group"><label>Ijasah Terakhir</label><input type="text" name="ijasah_terakhir" value="<?= $data['ijasah_terakhir'] ?>"></div>
        <div class="form-group">
          <label>Jenis Kelamin</label>
          <select name="jenis_kelamin">
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="L" <?= selected($data['jenis_kelamin'], 'L') ?>>Laki-laki</option>
            <option value="P" <?= selected($data['jenis_kelamin'], 'P') ?>>Perempuan</option>
          </select>
        </div>
        <div class="form-group"><label>Jabatan</label><input type="text" name="jabatan" value="<?= $data['jabatan'] ?>"></div>
        <div class="form-group"><label>Rumpun Jabatan</label><input type="text" name="rumpun_jabatan" value="<?= $data['rumpun_jabatan'] ?>"></div>
        <div class="form-group" style="grid-column: span 2;"><label>Alamat</label><textarea name="alamat"><?= $data['alamat'] ?></textarea></div>
        <div class="form-group"><label>TMT</label><input type="date" name="tmt" value="<?= $data['tmt'] ?>"></div>
        <div class="form-group">
          <label>Data BKN/Non</label>
          <select name="data_bkn_non">
            <option value="">-- Pilih Status --</option>
            <option value="BKN" <?= selected($data['data_bkn_non'], 'BKN') ?>>BKN</option>
            <option value="NON BKN" <?= selected($data['data_bkn_non'], 'NON BKN') ?>>Non BKN</option>
          </select>
        </div>

        <div class="form-group">
          <label>Status</label>
          <select name="status">
            <option value="">-- Pilih Status --</option>
            <option value="Kontrak" <?= selected($data['status'], 'Kontrak') ?>>Kontrak</option>
            <option value="Pegawai Tetap" <?= selected($data['status'], 'Pegawai Tetap') ?>>Pegawai Tetap</option>
          </select>
        </div>

        <div class="btn-group">
          <a href="nonasn.php" class="btn-back">← Kembali</a>
          <button type="submit" class="btn-submit">💾 Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>