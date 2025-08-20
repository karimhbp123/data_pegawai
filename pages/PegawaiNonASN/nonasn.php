<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}
include '../../config/db.php';

$result = mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn ORDER BY id DESC");
$pegawaiData = [];
while ($row = mysqli_fetch_assoc($result)) {
  $pegawaiData[] = $row;
}
$deletedResult = mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn_terhapus ORDER BY deleted_at DESC");
$deletedData = [];
while ($row = mysqli_fetch_assoc($deletedResult)) {
  $deletedData[] = $row;
}
$showModal = false;
if (isset($_GET['notif']) && $_GET['notif'] === 'hapus') {
  $showModal = true;
}
$jumlahTerhapus = count($deletedData);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Pegawai Non ASN</title>
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
      overflow: hidden;
    }

    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #2c3e50, #34495e);
      color: #fff;
      padding: 20px;
      flex-shrink: 0;
    }

    .sidebar h3 {
      margin-bottom: 20px;
      font-size: 20px;
      color: #ecf0f1;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #bdc3c7;
      font-weight: 500;
      padding: 10px 14px;
      border-radius: 8px;
      margin-bottom: 10px;
      transition: background 0.3s, color 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #1abc9c;
      color: white;
    }

    .main-content {
      flex: 1;
      padding: 40px 50px;
      overflow: hidden;
      position: relative;
    }

    .header-box {
      background: #fbfbfb;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .page-title {
      font-size: 22px;
      color: #2c3e50;
    }

    .notif-button {
      background-color: #e74c3c;
      border: none;
      border-radius: 50%;
      color: white;
      font-size: 18px;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
      cursor: pointer;
      animation: pulse 1.5s infinite;
      transition: background-color 0.3s ease;
    }

    .notif-button:hover {
      background-color: #c0392b;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.3);
      }

      100% {
        transform: scale(1);
      }
    }

    .notif-badge {
      position: absolute;
      top: -4px;
      right: -4px;
      background-color: #ffdc00;
      color: #2c3e50;
      font-size: 11px;
      font-weight: bold;
      padding: 2px 6px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }


    .table-scroll {
      overflow-x: auto;
      overflow-y: auto;
      max-height: 680px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background: #fff;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    /* ✅ Gaya umum untuk semua tabel */
    table {
      width: 100%;
      min-width: 1400px;
      border-collapse: collapse;
      background-color: white;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 6px 8px;
      text-align: left;
      font-size: 13px;
      vertical-align: middle;
    }

    thead th {
      background: linear-gradient(to right, #2c3e50, #34495e);
      color: white;
      position: sticky;
      top: 0;
      z-index: 2;
      font-size: 11px;
      height: 42px;
    }


    tbody tr {
      height: 32px;
    }

    tr:hover {
      background-color: #f9fbfc;
    }


    .action-container {
      display: flex;
      gap: 6px;
      justify-content: start;
    }

    .action-link {
      padding: 6px 10px;
      font-size: 13px;
      border-radius: 6px;
      text-decoration: none;
      color: white;
      display: inline-block;
      white-space: nowrap;
    }

    .edit {
      background: #f1c40f;
    }

    .delete {
      background: #e74c3c;
    }

    .filter-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 20px;
    }

    .filter-left {
      display: flex;
      gap: 12px;
      align-items: center;
      flex-wrap: wrap;
    }

    .filter-left select,
    .filter-left input {
      padding: 7px 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    .button-group {
      display: flex;
      gap: 10px;
    }

    .btn-blue,
    .btn-green {
      padding: 8px 12px;
      border-radius: 6px;
      color: white;
      text-decoration: none;
      font-size: 14px;
      font-weight: bold;
    }

    .btn-blue {
      background-color: #8e44ad;
    }

    .btn-green {
      background-color: #2ecc71;
    }

    /* ✅ MODAL STYLES */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .modal-content {
      background-color: #fff;
      border-radius: 12px;
      width: 96%;
      max-width: 1400px;
      margin: auto;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      padding: 30px;
      overflow-y: auto;
      max-height: 80vh;
      position: relative;
    }

    .modal-content .close-btn {
      position: absolute;
      top: 18px;
      right: 20px;
      font-size: 22px;
      color: #888;
      cursor: pointer;
    }

    .modal-content .close-btn:hover {
      color: #e74c3c;
    }

    .modal-header {
      display: flex;
      align-items: center;
      gap: 10px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 12px;
      margin-bottom: 20px;
    }

    .modal-title-icon {
      font-size: 22px;
    }

    .modal-title-text {
      font-size: 20px;
      font-weight: 600;
      color: #2c3e50;
    }

    .action-link.delete:hover::after {
      content: " Hapus permanen";
      font-size: 11px;
      margin-left: 4px;
      color: #fff;
    }

    .action-link.edit:hover::after {
      content: " Edit data";
      font-size: 11px;
      margin-left: 4px;
      color: #fff;
    }

    #notifModal table thead th,
    #notifModal table tbody td {
      /* border: 1px solid #ccc; */
      font-size: 13px;
      white-space: nowrap;
      padding: 6px 10px;
    }

    /* Kolom panjang di modal - lebih lebar dari default */
    /* #notifModal table thead th:nth-child(3), */
    #notifModal table thead th:nth-child(4),
    #notifModal table thead th:nth-child(5),
    #notifModal table thead th:nth-child(6),
    #notifModal table thead th:nth-child(8),
    #notifModal table thead th:nth-child(9),
    #notifModal table thead th:nth-child(12),
    #notifModal table thead th:nth-child(13),
    #notifModal table thead th:nth-child(15),
    #notifModal table thead th:nth-child(16),
    #notifModal table thead th:nth-child(18),
    #notifModal table thead th:nth-child(19),
    /* #notifModal table tbody td:nth-child(3), */
    #notifModal table tbody td:nth-child(4),
    #notifModal table tbody td:nth-child(5),
    #notifModal table tbody td:nth-child(6),
    #notifModal table tbody td:nth-child(8),
    #notifModal table tbody td:nth-child(9),
    #notifModal table tbody td:nth-child(12),
    #notifModal table tbody td:nth-child(13),
    #notifModal table tbody td:nth-child(15),
    #notifModal table tbody td:nth-child(16),
    #notifModal table tbody td:nth-child(18),
    #notifModal table tbody td:nth-child(19) {
      min-width: 220px;
      max-width: 350px;
      overflow-wrap: break-word;
      word-wrap: break-word;
      word-break: break-word;
      white-space: normal;
    }

    /*  Kolom panjang agar tidak pecah  */
    th:nth-child(3),
    th:nth-child(4),
    th:nth-child(7),
    th:nth-child(9),
    th:nth-child(12),
    th:nth-child(13),
    th:nth-child(15),
    th:nth-child(16),
    td:nth-child(3),
    td:nth-child(4),
    td:nth-child(7),
    td:nth-child(9),
    td:nth-child(12),
    td:nth-child(13),
    td:nth-child(15),
    td:nth-child(16) {
      white-space: nowrap;
      min-width: 200px;
      max-width: 500px;
    }

    th:nth-child(18),
    td:nth-child(18) {
      min-width: 95px;
      max-width: 400px;
    }

    td:nth-child(19),
    th:nth-child(19) {
      min-width: 75px;
      max-width: 400px;
    }
        td:nth-child(20),
    th:nth-child(20){
      min-width: 105px;
      max-width: 400px;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h3>📊 Data Pegawai</h3>
    <a href="../dashboard.php">🏠 Dashboard</a>
    <a href="../PegawaiASN/asn.php">👨‍💼 Pegawai ASN</a>
    <a href="nonasn.php" class="active">👷 Pegawai Non ASN</a>
  </div>

  <!-- Main content -->
  <div class="main-content">
    <div class="header-box">
      <h2 class="page-title">👨‍💼 Data Pegawai Non ASN</h2>
      <div style="position: relative;">
        <button class="notif-button" onclick="document.getElementById('notifModal').style.display='flex'">🔔</button>
        <?php if ($jumlahTerhapus > 0): ?>
          <div class="notif-badge"><?= $jumlahTerhapus ?></div>
        <?php endif; ?>
      </div>


    </div>

    <!-- Filter -->
    <div class="filter-bar">
      <div class="filter-left">
        <label for="limit">Tampilkan:</label>
        <select id="limit" onchange="applyFilter()">
          <option value="0">Semua</option>
          <option value="15" selected>15 data</option>
          <option value="20">20 data</option>
          <option value="30">30 data</option>
          <option value="100">100 data</option>
        </select>
        <input type="text" id="search" placeholder="🔍 Cari nama pegawai..." onkeyup="applyFilter()">
      </div>
      <div class="button-group">
        <a href="export_excel_nonasn.php" class="btn-blue" target="_blank">⬇️ Excel</a>
        <?php if ($_SESSION['role'] === 'admin') : ?>
          <a href="add_nonasn.php" class="btn-green">➕ Tambah</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Modal -->
    <div id="notifModal" class="modal">
      <div class="modal-content">
        <span class="close-btn" onclick="document.getElementById('notifModal').style.display='none'">&times;</span>
        <div class="modal-header">
          <span class="modal-title-icon">🗑️</span>
          <h3 class="modal-title-text">Daftar Pegawai yang Telah Dihapus</h3>
        </div>
        <div class="table-scroll">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <?php if ($_SESSION['role'] === 'admin') : ?>
                  <th>Aksi</th>
                <?php endif; ?>
                <th>Pegawai yang keluar</th>
                <th>Nama</th>
                <th>Nama tanpa gelar</th>
                <th>NIK</th>
                <th>NIP</th>
                <th>Ruang</th>
                <th>Tempat Lahir</th>
                <th>TTL</th>
                <th>Agama</th>
                <th>Pendidikan</th>
                <th>Program Studi</th>
                <th>Ijazah Terakhir</th>
                <th>Kelamin</th>
                <th>Jabatan</th>
                <th>Rumpun Jabatan</th>
                <th>Alamat</th>
                <th>TMT</th>
                <th>BKN/Non</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($deletedData as $del): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <?php if ($_SESSION['role'] === 'admin') : ?>
                    <td>
                      <a href="../../proses/PegawaiNonASN/hapus_permanen.php?id=<?= $del['id'] ?>" class="action-link delete" onclick="return confirm('Hapus permanen data ini?')">🗑️</a>
                    </td>
                  <?php endif; ?>
                  <td><?= htmlspecialchars(date('d-m-Y H:i', strtotime($del['deleted_at']))) ?></td>
                  <td><?= htmlspecialchars($del['nama']) ?></td>
                  <td><?= htmlspecialchars($del['nama_tanpa_gelar']) ?></td>
                  <td><?= htmlspecialchars($del['nik']) ?></td>
                  <td><?= htmlspecialchars($del['nip']) ?></td>
                  <td><?= htmlspecialchars($del['ruang']) ?></td>
                  <td><?= htmlspecialchars($del['tempat_lahir']) ?></td>
                  <td><?= htmlspecialchars(date('d-m-Y', strtotime($del['ttl']))) ?></td>
                  <td><?= htmlspecialchars($del['agama']) ?></td>
                  <td><?= htmlspecialchars($del['pendidikan']) ?></td>
                  <td><?= htmlspecialchars($del['program_studi']) ?></td>
                  <td><?= htmlspecialchars($del['ijasah_terakhir']) ?></td>
                  <td><?= htmlspecialchars($del['jenis_kelamin']) ?></td>
                  <td><?= htmlspecialchars($del['jabatan']) ?></td>
                  <td><?= htmlspecialchars($del['rumpun_jabatan']) ?></td>
                  <td><?= htmlspecialchars($del['alamat']) ?></td>
                  <td><?= htmlspecialchars(date('d-m-Y', strtotime($del['tmt']))) ?></td>
                  <td><?= htmlspecialchars($del['data_bkn_non']) ?></td>
                  <td><?= htmlspecialchars($del['status']) ?></td>
                </tr>
              <?php endforeach; ?>
              <?php if (empty($deletedData)): ?>
                <tr>
                  <td colspan="21" style="text-align:left;">Tidak ada data yang dihapus.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="table-scroll">
      <table id="pegawaiTable">
        <thead>
          <tr>
            <th>No</th> <!-- ✅ Tambahkan kolom nomor di awal -->
            <?php if ($_SESSION['role'] === 'admin') : ?>
              <th>Aksi</th>
            <?php endif; ?>
            <th onclick="sortTable()" style="cursor:pointer; user-select:none; height: 42px;">
              <div style="display: flex; align-items: center; justify-content: center; gap: 4px;">
                <span>Nama</span>
                <span id="sort-icon" style="display: inline-block; font-size: 12px; transition: color 0.3s ease; color: #fff; line-height: 1;">⇅</span>
              </div>
            </th>
            <th>Nama tanpa gelar</th>
            <th>NIK</th>
            <th>NIP</th>
            <th>Ruang</th>
            <th>Tempat lahir</th>
            <th>TTL</th>
            <th>Agama</th>
            <th>Pendidikan</th>
            <th>Program studi</th>
            <th>Ijasah terakhir</th>
            <th>kelamin</th>
            <th>Jabatan</th>
            <th>Rumpun jabatan</th>
            <th>Alamat</th>
            <th>TMT</th>
            <th>BKN/Non</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          foreach ($pegawaiData as $row): ?>
            <tr>
              <td><?= $no++ ?></td> <!-- ✅ Kolom No -->
              <?php if ($_SESSION['role'] === 'admin') : ?>
                <td>
                  <div class="action-container">
                    <a href="edit_nonasn.php?id=<?= $row['id'] ?>" class="action-link edit">✏️</a>
                    <a href="../../proses/PegawaiNonASN/delete_nonasn.php?id=<?= $row['id'] ?>&redirect=nonasn.php" class="action-link delete" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️</a>
                  </div>
                </td>
              <?php endif; ?>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['nama_tanpa_gelar']) ?></td>
              <td><?= htmlspecialchars($row['nik']) ?></td>
              <td><?= htmlspecialchars($row['nip']) ?></td>
              <td><?= htmlspecialchars($row['ruang']) ?></td>
              <td><?= htmlspecialchars($row['tempat_lahir']) ?></td>
              <td><?= date('d-m-Y', strtotime($row['ttl'])) ?></td>
              <td><?= htmlspecialchars($row['agama']) ?></td>
              <td><?= htmlspecialchars($row['pendidikan']) ?></td>
              <td><?= htmlspecialchars($row['program_studi']) ?></td>
              <td><?= htmlspecialchars($row['ijasah_terakhir']) ?></td>
              <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
              <td><?= htmlspecialchars($row['jabatan']) ?></td>
              <td><?= htmlspecialchars($row['rumpun_jabatan']) ?></td>
              <td><?= htmlspecialchars($row['alamat']) ?></td>
              <td><?= date('d-m-Y', strtotime($row['tmt'])) ?></td>
              <td><?= htmlspecialchars($row['data_bkn_non']) ?></td>
              <td><?= htmlspecialchars($row['status']) ?></td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($pegawaiData)): ?>
            <tr>
              <td colspan="21" style="text-align:center;">Tidak ada data pegawai ditemukan.</td>
            </tr>
          <?php endif; ?>

        </tbody>
      </table>
    </div>
  </div>
  <script>
    function applyFilter() {
      const search = document.getElementById("search").value.toLowerCase().trim();
      const limit = parseInt(document.getElementById("limit").value);
      const rows = document.querySelectorAll("#pegawaiTable tbody tr");
      let shown = 0;

      rows.forEach(row => {
        const cells = Array.from(row.querySelectorAll("td"));
        const match = cells.some(cell => cell.textContent.toLowerCase().includes(search));

        if (match) {
          if (limit === 0 || shown < limit) {
            row.style.display = "";
            shown++;
          } else {
            row.style.display = "none";
          }
        } else {
          row.style.display = "none";
        }
      });

      // Optional: Atur tinggi scroll area secara dinamis
      const tableScroll = document.querySelector('.table-scroll');
      const visibleRows = [...rows].filter(row => row.style.display !== "none");

      if (search.length > 0 && visibleRows.length < 10) {
        tableScroll.style.height = 'auto';
      } else {
        tableScroll.style.height = '680px';
      }
    }


    let sortState = 0; // 0 = default, 1 = asc, 2 = desc
    const originalOrder = Array.from(document.querySelectorAll("#pegawaiTable tbody tr")); // simpan urutan awal

    function sortTable() {
      const table = document.getElementById("pegawaiTable");
      const tbody = table.querySelector("tbody");
      const rows = Array.from(tbody.querySelectorAll("tr"));
      const namaIndex = <?= ($_SESSION['role'] === 'admin') ? 2 : 1 ?>;
      const icon = document.getElementById("sort-icon");

      if (sortState === 0) {
        // A-Z
        rows.sort((a, b) => {
          const namaA = a.cells[namaIndex].textContent.toLowerCase();
          const namaB = b.cells[namaIndex].textContent.toLowerCase();
          return namaA.localeCompare(namaB);
        });
        icon.style.color = "#1abc9c";
        sortState = 1;
      } else if (sortState === 1) {
        // Z-A
        rows.sort((a, b) => {
          const namaA = a.cells[namaIndex].textContent.toLowerCase();
          const namaB = b.cells[namaIndex].textContent.toLowerCase();
          return namaB.localeCompare(namaA);
        });
        icon.style.color = "#f1c40f";
        sortState = 2;
      } else {
        // Kembali ke urutan default (ID DESC)
        tbody.innerHTML = "";
        originalOrder.forEach(row => tbody.appendChild(row));
        icon.style.color = "#fff";
        sortState = 0;
        applyFilter();
        return;
      }

      tbody.innerHTML = "";
      rows.forEach(row => tbody.appendChild(row));

      // Efek animasi
      icon.style.animation = "pulse 0.4s ease";
      setTimeout(() => {
        icon.style.animation = "none";
      }, 400);

      applyFilter();
    }

    window.onload = function() {
      <?php if ($showModal): ?>
        document.getElementById('notifModal').style.display = 'flex';
      <?php endif; ?>
      applyFilter();
    };
  </script>

</body>

</html>