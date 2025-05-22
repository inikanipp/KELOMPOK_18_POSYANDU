<?php
include '../koneksi.php';
// query view kunjungan posyandu
$sql = "SELECT * FROM view_kunjungan_posyandu ORDER BY tanggal_kunjungan DESC";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Kunjungan Posyandu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
    table th {
      background-color: #ec407a;
      color: white;
    }
    .btn-sm {
      font-size: 0.75rem;
    }
  </style>
</head>
<body>
  <!-- sidebar -->
  <div class="sidebar d-flex flex-column p-3">
    <div class="d-flex align-items-center justify-content-center mb-4">
      <img src="assets/POSYANDU.png" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px; border-radius: 30%;">
      <a href="dashboard.php" class="text-decoration-none">
        <h4 class="m-0" style="color: #ec407a;">Dashboard</h4>
      </a>
    </div>
    <ul class="nav nav-pills flex-column">
      <li class="nav-item">
        <a href="kunjungan.php" class="nav-link active">Data Kunjungan Posyandu</a>
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
  <!-- sidebar end -->
  <div class="content">
    <h2>Data Kunjungan Posyandu</h2>
    <div class="card mt-4">
      <div class="card-header">Daftar Kunjungan Anak</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Jenis Kelamin</th>
                <th>Nama Ibu</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Tanggal Kunjungan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($result->num_rows > 0) {
                  $no = 1;
                  while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $no++ . "</td>";
                      echo "<td>" . htmlspecialchars($row['nama_balita']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['jenis_kelamin']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['nama_ibu']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['no_hp']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['tanggal_kunjungan']) . "</td>";
                      echo "</tr>";
                  }
              } else {
                  echo "<tr><td colspan='12' class='text-center'>Data tidak ditemukan</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$koneksi->close();
?>
