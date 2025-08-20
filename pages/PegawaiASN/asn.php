<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}
include '../../config/db.php';


// ========== HANDLER AJAX DETAIL ==========
if (isset($_GET['detail_id'])) {
  $id = intval($_GET['detail_id']);
  $result = mysqli_query($koneksi, "SELECT * FROM pegawai_asn WHERE id='$id'");
  $data = mysqli_fetch_assoc($result);

  if (!$data) {
    echo "<p>Data tidak ditemukan.</p>";
    exit;
  }

  echo "<table class='modal-details'>";
  foreach ($data as $key => $value) {
    // field yang sudah ditampilkan di tabel utama jangan ditampilkan ulang
    if (in_array($key, ['id', 'nama', 'nip', 'nik', 'tempat_lahir', 'ttl', 'gol_terakhir', 'jabatan', 'ruang'])) continue;

    // format tanggal
    if (in_array($key, ['tmt_cpns', 'tmt_gol_terakhir', 'tmt_jabatan', 'tmt_masuk', 'rencana_kgb', 'tgl_akta_nikah', 'tgl_str', 'masa_berlaku', 'tgl_sip']) && $value) {
      $value = date('d-m-Y', strtotime($value));
    }

    if ($value === '' || $value === null) {
      $value = '-';
    }

    echo "<tr><td>" . ucwords(str_replace('_', ' ', $key)) . "</td><td>" . htmlspecialchars($value) . "</td></tr>";
  }
  echo "</table>";
  exit; // <- STOP di sini supaya tidak render HTML penuh
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Pegawai ASN</title>
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

    .main-content {
      flex: 1;
      padding: 40px 50px;
    }

    .header-box {
      background: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    h2.page-title {
      font-size: 22px;
      color: #2c3e50;
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

    .button-group a {
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

    .btn-red {
      background-color: #e74c3c;
    }

    .table-scroll {
      max-height: 680px;
      overflow-y: auto;
      overflow-x: auto;
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      position: relative;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }

    table {
      width: 100%;
      min-width: 1200px;
      border-collapse: collapse;
      background-color: white;
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

    th,
    td {
      border: 1px solid #ccc;
      padding: 6px 8px;
      text-align: left;
      font-size: 13px;
      vertical-align: middle;
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
      align-items: center;
      justify-content: start;
      flex-wrap: nowrap;
    }

    .action-link {
      padding: 6px 10px;
      font-size: 13px;
      border-radius: 6px;
      text-decoration: none;
      color: white;
      white-space: nowrap;
      display: inline-block;
    }

    .edit {
      background: #f1c40f;
    }

    .delete {
      background: #e74c3c;
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

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 15px;
      backdrop-filter: blur(4px);
    }


    .modal-content {
      background: #ffffff;
      border-radius: 14px;
      padding: 25px 30px;
      max-width: 75%;
      width: auto;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
      max-height: 90vh;
      overflow-y: auto;
      overflow-x: hidden;
      position: relative;
      animation: scaleFadeIn 0.3s ease;
    }



    @keyframes scaleFadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    /* Header modal */
    .modal-content h3 {
      margin-top: 0;
      font-size: 22px;
      font-weight: 600;
      border-bottom: 2px solid #1abc9c;
      padding-bottom: 12px;
      margin-bottom: 20px;
      color: #111827;
    }

    .modal-dialog {
      max-width: 600px;
      margin: 30px auto;
    }

    /* Tombol close */
    .close-btn {
      position: absolute;
      right: 20px;
      top: 18px;
      font-size: 24px;
      cursor: pointer;
      color: #6b7280;
      transition: all 0.2s;
    }

    .close-btn:hover {
      color: #ef4444;
      transform: scale(1.1);
    }

    .modal-details {
      width: 100%;
      max-width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      font-size: 14px;
      table-layout: fixed;
      word-wrap: break-word;

    }

    .modal-details td {
      padding: 10px 12px;
      vertical-align: top;
    }

    .modal-details td:first-child {
      width: 35%;
      font-weight: 600;
      background: #f0fdfa;
      color: #065f46;
      border-right: 1px solid #d1fae5;
      border-top-left-radius: 8px;
      border-bottom-left-radius: 8px;
    }

    .modal-details td:last-child {
      width: 75%;
      background: #ffffff;
      color: #111827;
      border-top-right-radius: 8px;
      border-bottom-right-radius: 8px;
    }

    .modal-details tr:nth-child(even) td:last-child {
      background: #f9fafb;
    }

    .modal-details tr:hover td:last-child {
      background: #e0f2fe;
    }

    .btn-detail {
      background: #2563eb;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
    }

    .btn-detail .icon {
      font-size: 14px;
      line-height: 1;
    }

    .btn-detail:hover {
      background: #1e40af;
    }

    #detailModal {
      display: none;
    }

    /* Kolom TTL */
    table th:nth-child(<?= ($_SESSION['role'] === 'admin') ? 7 : 6 ?>),
    table td:nth-child(<?= ($_SESSION['role'] === 'admin') ? 7 : 6 ?>) {
      width: 120px;
      white-space: nowrap;
    }

    /* Kolom Golongan Terakhir */
    table th:nth-child(<?= ($_SESSION['role'] === 'admin') ? 8 : 7 ?>),
    table td:nth-child(<?= ($_SESSION['role'] === 'admin') ? 8 : 7 ?>) {
      width: 100px;
      white-space: nowrap;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h3>📊 Data Pegawai</h3>
    <a href="../dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == '../dashboard.php' ? 'active' : '' ?>">🏠 Dashboard</a>
    <a href="asn.php" class="<?= basename($_SERVER['PHP_SELF']) == 'asn.php' ? 'active' : '' ?>">👨‍💼 Pegawai ASN</a>
    <a href="../PegawaiNonASN/nonasn.php" class="<?= basename($_SERVER['PHP_SELF']) == '../PegawaiNonASN/nonasn.php' ? 'active' : '' ?>">👷 Pegawai Non ASN</a>
  </div>

  <div class="main-content">
    <div class="header-box">
      <h2 class="page-title">👨‍💼 Data Pegawai ASN</h2>
    </div>
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
        <a href="export_excel.php" class="btn-blue" target="_blank">⬇️ Excel</a>
        <?php if ($_SESSION['role'] === 'admin') : ?>
          <a href="add.php" class="btn-green">➕ Tambah</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="table-scroll">
      <table id="pegawaiTable">
        <thead>
          <tr>
            <th>No</th>
            <?php if ($_SESSION['role'] === 'admin') : ?><th>Aksi</th><?php endif; ?>
            <th onclick="sortTable()" style="cursor:pointer;">Nama <span id="sort-icon">⇅</span></th>
            <th>NIK</th>
            <th>NIP</th>
            <th>Tempat Lahir</th>
            <th>TTL</th>
            <th>Golongan Terakhir</th>
            <th>Nama Jabatan</th>
            <th>Ruang</th>
            <th>Lainnya</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $query = mysqli_query($koneksi, "SELECT * FROM pegawai_asn ORDER BY nama ASC");
          while ($row = mysqli_fetch_assoc($query)) :
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <?php if ($_SESSION['role'] === 'admin'): ?>
                <td class="action-container">
                  <a href="edit.php?id=<?= $row['id']; ?>" class="action-link edit">✏️ Edit</a>
                  <a href="../../proses/PegawaiASN/delete.php?id=<?= $row['id']; ?>" class="action-link delete" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑 Hapus</a>
              <?php endif; ?>
              <td><?= htmlspecialchars($row['nama']); ?></td>
              <td><?= htmlspecialchars($row['nik'] ?? '-'); ?></td>
              <td><?= htmlspecialchars($row['nip'] ?? '-'); ?></td>
              <td><?= htmlspecialchars($row['tempat_lahir'] ?? '-'); ?></td>
              <td><?= $row['ttl'] ? date('d-m-Y', strtotime($row['ttl'])) : '-'; ?></td>
              <td><?= htmlspecialchars($row['gol_terakhir'] ?? '-'); ?></td>
              <td><?= htmlspecialchars($row['jabatan'] ?? '-'); ?></td>
              <td><?= htmlspecialchars($row['ruang'] ?? '-'); ?></td>
              <td>
                <button class="btn-detail" onclick="openModal(<?= $row['id']; ?>)">
                  <span class="icon">🔍</span>
                  <span>Detail</span>
                </button>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Detail -->
  <div id="detailModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h3>Detail Pegawai ASN</h3>
      <div id="modalBody"></div>
    </div>
  </div>

  <script>
    let sortState = 0,
      originalOrder = [];

    function applyFilter() {
      const search = document.getElementById("search").value.toLowerCase();
      const limit = parseInt(document.getElementById("limit").value);
      const rows = document.querySelectorAll("#pegawaiTable tbody tr");
      let shown = 0;
      rows.forEach(row => {
        const namaIndex = <?= ($_SESSION['role'] === 'admin') ? 2 : 1 ?>;
        const nama = row.cells[namaIndex].textContent.toLowerCase();
        const match = nama.includes(search);
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
    }

    function sortTable() {
      const table = document.getElementById("pegawaiTable");
      const tbody = table.querySelector("tbody");
      let rows = Array.from(tbody.querySelectorAll("tr"));
      const namaIndex = <?= ($_SESSION['role'] === 'admin') ? 2 : 1 ?>;
      const icon = document.getElementById("sort-icon");
      if (!originalOrder.length) {
        originalOrder = [...rows];
      }
      if (sortState === 0) {
        rows.sort((a, b) => a.cells[namaIndex].textContent.localeCompare(b.cells[namaIndex].textContent));
        icon.style.color = "#1abc9c";
        sortState = 1;
      } else if (sortState === 1) {
        rows.sort((a, b) => b.cells[namaIndex].textContent.localeCompare(a.cells[namaIndex].textContent));
        icon.style.color = "#f1c40f";
        sortState = 2;
      } else {
        tbody.innerHTML = "";
        originalOrder.forEach(row => tbody.appendChild(row));
        icon.style.color = "#fff";
        sortState = 0;
        applyFilter();
        return;
      }
      tbody.innerHTML = "";
      rows.forEach(row => tbody.appendChild(row));
      applyFilter();
    }

    function openModal(id) {
      const modal = document.getElementById("detailModal");
      const modalBody = document.getElementById("modalBody");
      modal.style.display = "flex";
      fetch("asn.php?detail_id=" + id)
        .then(res => res.text())
        .then(html => {
          modalBody.innerHTML = html;
        }).catch(() => {
          modalBody.innerHTML = "";
        });
    }

    function closeModal() {
      document.getElementById("detailModal").style.display = "none";
    }
    window.onclick = function(e) {
      const modal = document.getElementById("detailModal");
      if (e.target === modal) {
        modal.style.display = "none";
      }
    }
    window.onload = applyFilter;
  </script>

</body>

</html>