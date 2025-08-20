<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}
include '../config/db.php';

$asn_laki = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pegawai_asn WHERE jenis_kelamin='Laki-laki'"));
$asn_perempuan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pegawai_asn WHERE jenis_kelamin='Perempuan'"));
$total_asn = $asn_laki + $asn_perempuan;

$nonasn_laki = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn WHERE jenis_kelamin='L'"));
$nonasn_perempuan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn WHERE jenis_kelamin='P'"));
$total_nonasn = $nonasn_laki + $nonasn_perempuan;

// Non ASN berdasarkan status kepegawaian
$nonasn_kontrak = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn WHERE status='Kontrak'"));
$nonasn_tetap = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn WHERE status='Pegawai tetap'"));

// Non ASN berdasarkan jenis kepegawaian
$nonasn_bkn = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn WHERE data_bkn_non='BKN'"));
$nonasn_nonbkn = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pegawai_non_asn WHERE data_bkn_non='Non BKN'"));

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html,
    body {
      height: 100%;
      font-family: 'Inter', sans-serif;
      overflow-x: hidden;
      overflow-y: auto;
    }

    body {
      display: flex;
    }

    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #2c3e50, #34495e);
      color: white;
      display: flex;
      flex-direction: column;
      padding: 20px;
      flex-shrink: 0;
    }

    .sidebar h3 {
      font-size: 20px;
      margin-bottom: 20px;
    }

    .sidebar a {
      color: #ced4da;
      text-decoration: none;
      padding: 10px 14px;
      border-radius: 6px;
      margin-bottom: 10px;
      display: block;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #17a2b8;
      color: white;
    }

    .logout-btn {
      margin-top: auto;
      color: #f8d7da;
      background: #dc3545;
      text-align: center;
      padding: 10px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
    }

    .logout-btn:hover {
      background: #c82333;
    }

    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      background: #f4f6f9;
      height: 100vh;
      overflow: hidden;
    }

    .main-wrapper {
      flex: 1;
      overflow-y: auto;
      padding: 20px 30px 10px;
      height: calc(100vh - 80px);
      /* Tambahkan height eksplisit */
    }

    #clock {
      margin-bottom: 24px;
    }

    .clock-box {
      background: linear-gradient(to right, #007bff, #6610f2);
      color: white;
      padding: 16px 24px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      font-weight: 600;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      min-width: 260px;
      font-family: 'Inter', sans-serif;
    }

    .clock-time {
      font-size: 20px;
      letter-spacing: 1px;
      font-variant-numeric: tabular-nums;
    }

    .clock-date {
      font-size: 14px;
      margin-top: 4px;
      color: rgba(255, 255, 255, 0.85);
    }

    .top-row {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      gap: 24px;
    }

    .summary-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 16px;
      flex: 1;
      min-width: 280px;
    }

    .chart-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .card-summary {
      padding: 20px;
      border-radius: 10px;
      color: white;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      display: flex;
      align-items: center;
      min-width: 0;
    }

    .card-icon {
      font-size: 32px;
      margin-right: 16px;
    }

    .card-info {
      display: flex;
      flex-direction: column;
    }

    .card-value {
      font-size: 24px;
      font-weight: bold;
    }

    .card-label {
      font-size: 14px;
    }

    .bg-primary {
      background-color: #007bff;
    }

    .bg-success {
      background-color: #28a745;
    }

    .bg-warning {
      background-color: #ffc107;
      color: #212529;
    }


    .chart-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .chart-card h4 {
      font-size: 16px;
      margin-bottom: 15px;
      color: #444;
    }

    .chart-card canvas {
      max-width: 140px !important;
      height: 140px !important;
      margin: 0 auto;
    }

    .chart-card-bar canvas {
      width: 100% !important;
      height: 260px !important;
    }

    footer {
      text-align: center;
      font-size: 12px;
      color: #888;
      padding: 16px;
      background: #f8f9fa;
      border-top: 1px solid #ddd;
    }
  </style>

</head>

<body>
  <div class="sidebar">
    <h3>📊 Data Pegawai</h3>
    <a href="dashboard.php" class="active">🏠 Dashboard</a>
    <a href="./PegawaiASN/asn.php">👨‍💼 Pegawai ASN</a>
    <a href="./PegawaiNonASN/nonasn.php">👷 Pegawai Non ASN</a>
    <a href="../" class="logout-btn">🚪 Logout</a>
  </div>

  <div class="main-content">
    <div class="main-wrapper">
      <div class="top-row">
        <div class="clock-box">
          <div class="clock-time" id="clock-time">--:--:--</div>
          <div class="clock-date" id="clock-date">Memuat tanggal...</div>
        </div>

        <div class="summary-cards">
          <div class="card-summary bg-primary">
            <div class="card-icon">👥</div>
            <div class="card-info">
              <div class="card-value"><?= $total_asn + $total_nonasn ?></div>
              <div class="card-label">Total Pegawai</div>
            </div>
          </div>
          <div class="card-summary bg-success">
            <div class="card-icon">🧑‍💼</div>
            <div class="card-info">
              <div class="card-value"><?= $total_asn ?></div>
              <div class="card-label">ASN</div>
            </div>
          </div>
          <div class="card-summary bg-warning">
            <div class="card-icon">👷‍♂️</div>
            <div class="card-info">
              <div class="card-value"><?= $total_nonasn ?></div>
              <div class="card-label">Non ASN</div>
            </div>
          </div>
        </div>
      </div>


      <div class="chart-section">
        <div class="chart-card">
          <h4>Diagram ASN</h4>
          <canvas id="pieChart"></canvas>
          <div style="margin-top: 10px; font-size: 14px; color: #555;">
            <strong>Laki-laki:</strong> <?= $asn_laki ?> orang<br>
            <strong>Perempuan:</strong> <?= $asn_perempuan ?> orang<br>
            <strong>Total ASN:</strong> <?= $total_asn ?> orang
          </div>
        </div>
        <div class="chart-card">
          <h4>Diagram Non ASN</h4>
          <canvas id="pieChartNonASN"></canvas>
          <div style="margin-top: 10px; font-size: 14px; color: #555;">
            <strong>Laki-laki:</strong> <?= $nonasn_laki ?> orang<br>
            <strong>Perempuan:</strong> <?= $nonasn_perempuan ?> orang<br>
            <strong>Total Non ASN:</strong> <?= $total_nonasn ?> orang
          </div>
        </div>
        <div class="chart-card">
          <h4>Perbandingan ASN & Non ASN</h4>
          <canvas id="comparisonChart"></canvas>
          <div style="margin-top: 10px; font-size: 14px; color: #555;">
            <strong>ASN:</strong> <?= $total_asn ?> orang<br>
            <strong>Non ASN:</strong> <?= $total_nonasn ?> orang<br>
            <strong>Total:</strong> <?= $total_asn + $total_nonasn ?> orang
          </div>
        </div>
      </div>
      <div class="chart-section">
        <div class="chart-card">
          <h4>Status Kepegawaian Non ASN</h4>
          <canvas id="pieChartStatusNonASN"></canvas>
          <div style="margin-top: 10px; font-size: 14px; color: #555;">
            <strong>Kontrak:</strong> <?= $nonasn_kontrak ?> orang<br>
            <strong>Pegawai tetap:</strong> <?= $nonasn_tetap ?> orang<br>
            <strong>Total:</strong> <?= $nonasn_kontrak + $nonasn_tetap ?> orang
          </div>
        </div>
        <div class="chart-card">
          <h4>Jenis Kepegawaian Non ASN</h4>
          <canvas id="pieChartJenisNonASN"></canvas>
          <div style="margin-top: 10px; font-size: 14px; color: #555;">
            <strong>BKN:</strong> <?= $nonasn_bkn ?> orang<br>
            <strong>Non BKN:</strong> <?= $nonasn_nonbkn ?> orang<br>
            <strong>Total:</strong> <?= $nonasn_bkn + $nonasn_nonbkn ?> orang
          </div>
        </div>
      </div>

    </div>

    <footer>
      © <?= date('Y') ?> Kepegawaian RSUD SLG KEDIRI - All rights reserved
    </footer>
  </div>

  <script>
    function updateClock() {
      const now = new Date();
      const time = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
      const date = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });

      document.getElementById('clock-time').innerText = time;
      document.getElementById('clock-date').innerText = date;
    }
    setInterval(updateClock, 1000);
    updateClock();

    new Chart(document.getElementById('pieChart'), {
      type: 'doughnut',
      data: {
        labels: ['Laki-laki', 'Perempuan'],
        datasets: [{
          data: [<?= $asn_laki ?>, <?= $asn_perempuan ?>],
          backgroundColor: ['#007bff', '#e83e8c'],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        cutout: '60%',
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    new Chart(document.getElementById('pieChartNonASN'), {
      type: 'doughnut',
      data: {
        labels: ['Laki-laki', 'Perempuan'],
        datasets: [{
          data: [<?= $nonasn_laki ?>, <?= $nonasn_perempuan ?>],
          backgroundColor: ['#28a745', '#fd7e14'],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        cutout: '60%',
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    new Chart(document.getElementById('comparisonChart'), {
      type: 'doughnut',
      data: {
        labels: ['ASN', 'Non ASN'],
        datasets: [{
          data: [<?= $total_asn ?>, <?= $total_nonasn ?>],
          backgroundColor: ['#007bff', '#6f42c1'],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        cutout: '60%',
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    new Chart(document.getElementById('pieChartStatusNonASN'), {
      type: 'doughnut',
      data: {
        labels: ['Kontrak', 'Pegawai tetap'],
        datasets: [{
          data: [<?= $nonasn_kontrak ?>, <?= $nonasn_tetap ?>],
          backgroundColor: ['#ffc107', '#20c997'],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        cutout: '60%',
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    // Pie Chart Jenis Kepegawaian Non ASN
    new Chart(document.getElementById('pieChartJenisNonASN'), {
      type: 'doughnut',
      data: {
        labels: ['BKN', 'Non BKN'],
        datasets: [{
          data: [<?= $nonasn_bkn ?>, <?= $nonasn_nonbkn ?>],
          backgroundColor: ['#6610f2', '#fd7e14'],
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        cutout: '60%',
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
  </script>
</body>

</html>