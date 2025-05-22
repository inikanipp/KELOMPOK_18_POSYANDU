<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Posyandu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      display: flex;
      background-color: #d6e87a;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .sidebar {
      width: 250px;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-right: 3px solid #ec407a;
      overflow-y: auto;
    }

    .sidebar h4 {
      color: #ec407a;
    }

    .sidebar .nav-link {
      color: #333;
      border-radius: 8px;
      margin-bottom: 8px;
    }

    .sidebar .nav-link.active {
      background-color: #ec407a;
      color: #fff;
    }

    .sidebar .nav-link:hover {
      background-color: #f8bbd0;
      color: #000;
    }

    .content {
      flex-grow: 1;
      padding: 30px;
    }

    .card {
      background-color: #ffffff;
      border: none;
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background-color: #ec407a;
      color: #fff;
      font-weight: bold;
      border-top-left-radius: 16px;
      border-top-right-radius: 16px;
    }

    h2 {
      color: #ec407a;
      font-weight: bold;
    }
  </style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
  <div class="d-flex align-items-center justify-content-center mb-4">
    <img src="assets/POSYANDU.png" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px; border-radius: 30%;">
    <a href="dashboard.php" class="text-decoration-none">
      <h4 class="m-0" style="color: #ec407a;">Dashboard</h4>
    </a>
  </div>
  <ul class="nav nav-pills flex-column">
    <li class="nav-item">
      <a href="kunjungan.php" class="nav-link">Data Kunjungan Posyandu</a>
    </li>
    <li class="nav-item">
      <a href="data_kader.php" class="nav-link">Data Kader</a>
    </li>
    <li class="nav-item">
      <a href="data_imunisasi.php" class="nav-link">Data Jenis Imunisasi</a>
    </li>
    <li class="nav-item">
      <a href="data_giziBuruk.php" class="nav-link">Daftar Gizi Buruk</a>
    </li>
    <li class="nav-item">
      <a href="rekap_imunisasi.php" class="nav-link">Rekap Imunisasi</a>
    </li>
    <li class="nav-item">
      <a href="jumlah_kunjungan.php" class="nav-link">Jumlah Kunjungan Bulanan</a>
    </li>
  </ul>
</div>
<!-- Sidebar End -->
  <div class="content">
    <h2>Selamat Datang di Ambasyandu</h2>
    <div class="card mt-4">
      <div class="card-header">
        Informasi Umum
      </div>
      <div class="card-body">
        <p class="card-text">Sistem ini membantu pengelolaan data kunjungan, imunisasi, dan status gizi anak di Posyandu.</p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
