<?php
include '../koneksi.php';
// query view rekap imunisasi
$sql = "SELECT * FROM view_rekap_imunisasi";
$result = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rekap Imunisasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { min-height: 100vh; display: flex; background-color: #d6e87a; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .sidebar { width: 250px; background-color: #fff; border-right: 3px solid #ec407a; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .sidebar h4 { color: #ec407a;}
    .sidebar .nav-link { color: #333; border-radius: 8px; margin-bottom: 8px; }
    .sidebar .nav-link.active { background-color: #ec407a; color: #fff; }
    .sidebar .nav-link:hover { background-color: #f8bbd0; color: #000; }
    .content { flex-grow: 1; padding: 30px; }
    .card { background-color: #fff; border: none; border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .card-header { background-color: #ec407a; color: #fff; font-weight: bold; border-top-left-radius: 16px; border-top-right-radius: 16px; }
    h2 { color: #ec407a; font-weight: bold; }
    table th { background-color: #ec407a; color: white; }
  </style>
</head>
<body>
  <div class="sidebar p-3">
    <div class="d-flex align-items-center justify-content-center mb-4">
      <img src="assets/POSYANDU.png" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px; border-radius: 30%;">
      <a href="dashboard.php" class="text-decoration-none">
        <h4 class="m-0" style="color: #ec407a;">Dashboard</h4>
      </a>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item"><a href="kunjungan.php" class="nav-link">Data Kunjungan Posyandu</a></li>
      <li class="nav-item"><a href="data_kader.php" class="nav-link">Data Kader</a></li>
      <li class="nav-item"><a href="data_imunisasi.php" class="nav-link">Data Jenis Imunisasi</a></li>
      <li class="nav-item"><a href="data_giziBuruk.php" class="nav-link">Daftar Gizi Buruk</a></li>
      <li class="nav-item"><a href="rekap_imunisasi.php" class="nav-link active">Rekap Imunisasi</a></li>
      <li class="nav-item"><a href="jumlah_kunjungan.php" class="nav-link">Jumlah Kunjungan Bulanan</a></li>
    </ul>
  </div>
  <div class="content">
    <h2>Rekapitulasi Imunisasi Anak</h2>
    <div class="card mt-4">
      <div class="card-header">Data Rekap Imunisasi</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Tanggal Kunjungan</th>
                <th>Jenis Imunisasi</th>
                <th>Tanggal Pemberian</th>
                <th>Usia Pemberian (tahun)</th>
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
                      echo "<td>" . htmlspecialchars(date('d-m-Y', strtotime($row['tgl_lahir']))) . "</td>";
                      echo "<td>" . htmlspecialchars(date('d-m-Y', strtotime($row['tanggal_kunjungan']))) . "</td>";
                      echo "<td>" . htmlspecialchars($row['nama_imunisasi']) . "</td>";
                      echo "<td>" . htmlspecialchars(date('d-m-Y', strtotime($row['tanggal_pemberian']))) . "</td>";
                      echo "<td>" . rtrim(rtrim(number_format($row['usia_pemberian'], 1, '.', ''), '0'), '.') . "</td>";
                      echo "</tr>";
                  }
              } else {
                  echo "<tr><td colspan='8' class='text-center'>Data tidak ditemukan</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<?php
$koneksi->close();
?>
