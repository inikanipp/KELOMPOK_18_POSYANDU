<?php
include '../koneksi.php';
$jenis_kelamin_data = ['Laki-laki' => 0, 'Perempuan' => 0];
$total_kunjungan = 0;
$error = null;
try {
    // sp kunjungan_sebulan_terakhir ambil data detail kunjungan
    $result = $koneksi->query("CALL kunjungan_sebulan_terakhir()");
    while ($row = $result->fetch_assoc()) {
        $jk = $row['Jenis Kelamin'];
        if (isset($jenis_kelamin_data[$jk])) {
            $jenis_kelamin_data[$jk]++;
        }
    }
    $result->free_result();
    while ($koneksi->more_results() && $koneksi->next_result()) {;}
    // sp cek_perbaris hitung total kunjungan
    $stmt = $koneksi->prepare("CALL cek_perbaris(@total)");
    $stmt->execute();
    $stmt->close();
    $res = $koneksi->query("SELECT @total AS total_kunjungan");
    $row = $res->fetch_assoc();
    $total_kunjungan = (int)$row['total_kunjungan'];
} catch (mysqli_sql_exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jumlah Kunjungan Posyandu Bulanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { min-height: 100vh; display: flex; background-color: #d6e87a; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; }
    .sidebar {
      width: 250px; background-color: #fff; border-right: 3px solid #ec407a; box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 1rem;
    }
    .sidebar h4 { color: #ec407a; margin-bottom: 1.5rem; }
    .sidebar .nav-link {
      color: #333; border-radius: 8px; margin-bottom: 8px; display: block; padding: 0.5rem 1rem; text-decoration: none;
    }
    .sidebar .nav-link.active, .sidebar .nav-link:hover {
      background-color: #ec407a; color: #fff; text-decoration: none;
    }
    .content {
      flex-grow: 1; padding: 30px;
    }
    .card {
      background-color: #fff; border: none; border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
    }
    .card-header {
      background-color: #ec407a; color: #fff; font-weight: bold;
      border-top-left-radius: 16px; border-top-right-radius: 16px;
      padding: 1rem 1.5rem;
    }
    h2 {
      color: #ec407a; font-weight: bold; margin-bottom: 1.5rem;
    }
    #pieChart {
      max-width: 300px; max-height: 300px; margin: auto; display: block;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="d-flex align-items-center justify-content-center mb-4">
      <img src="assets/POSYANDU.png" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px; border-radius: 30%;" />
      <a href="dashboard.php" class="text-decoration-none">
        <h4 class="m-0">Dashboard</h4>
      </a>
    </div>
    <nav>
      <a href="kunjungan.php" class="nav-link">Data Kunjungan Posyandu</a>
      <a href="data_kader.php" class="nav-link">Data Kader</a>
      <a href="data_imunisasi.php" class="nav-link">Data Jenis Imunisasi</a>
      <a href="data_giziBuruk.php" class="nav-link">Daftar Gizi Buruk</a>
      <a href="rekap_imunisasi.php" class="nav-link">Rekap Imunisasi</a>
      <a href="jumlah_kunjungan.php" class="nav-link active">Jumlah Kunjungan Bulanan</a>
    </nav>
  </div>
  <div class="content">
    <h2>Kunjungan 1 Bulan Terakhir</h2>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php else: ?>
      <div class="card">
        <div class="card-header">Total Kunjungan</div>
        <div class="card-body">
          <h4>Total: <strong><?= $total_kunjungan ?></strong> kunjungan</h4>
        </div>
      </div>
      <div class="card">
        <div class="card-header">Diagram Lingkaran Berdasarkan Jenis Kelamin</div>
        <div class="card-body">
          <canvas id="pieChart"></canvas>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <!-- js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: <?= json_encode(array_keys($jenis_kelamin_data)) ?>,
        datasets: [{
          label: 'Kunjungan',
          data: <?= json_encode(array_values($jenis_kelamin_data)) ?>,
          backgroundColor: ['#42a5f5', '#ec407a'],
          borderWidth: 1
        }]
      },
      options: {
        plugins: {
          legend: {
            position: 'bottom',
            labels: { color: '#333', font: { size: 14 } }
          }
        }
      }
    });
  </script>
</body>
</html>
<?php
$koneksi->close();
?>
