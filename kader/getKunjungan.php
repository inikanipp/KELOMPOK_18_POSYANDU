<?php 
require '../koneksi.php';


session_start();

if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../login.php");
    exit();
}

if(isset($_SESSION['username'])){
  $username = $_SESSION['username'];
  $id_kader = $_SESSION["id_kader"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sidebar Navbar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background-color: #ffffff;
    }

    .sidebar {
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      background-color: #ffffff;
      padding-top: 1rem;
      
    }

    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 0.75rem 1rem;
    }

    .sidebar a:hover {
      border-radius: 6px;
      background-color: #D8F273;
      color: #201F31;
    }

    .content {
      margin-left: 250px;
      padding: 2rem;
    }

  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="container rounded-3 pt-3" style="height: 98%; width: 90%; background-color: #201F31;">
      <h4 class="text-white text-center">Posyandu</h4>
      <a href="getKunjungan.php">Dashboard</a>
      <a href="addKunjungan.php?der=<?php echo $id_kader?>">Tambah Kunjungan</a>
    </div>
  </div>

 <!-- Content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col" style="height: 15vh;">
        <h1>Welcome Bunda <?php echo $username?></h1>
        <p>Yuk Tambahkan Balita pada Daftar Kunjungan Anda !</p>
      </div>
    </div>
    <?php 
      $sql2 = "SELECT COUNT(id_balita) AS jumlah FROM kunjungan_posyandu WHERE id_kader = $id_kader";
      $q2 = mysqli_query($koneksi,$sql2);

      if($r2 = mysqli_fetch_array($q2)){
          $jumlah   = $r2['jumlah'];


      ?>
    <!-- Card Container -->
    <div class="row p-4 rounded mb-3" style="height: 30vh;">
      <!-- Card 1 -->
      <div class="col mb-3">
        <div class="card h-100 bg-primary text-white">
          <div class="card-body">
            <h5 class="card-title">Total Balita</h5>
            <div class="container d-flex justify-content-center align-items-center" style="height: 85%; width: 100%;">
              <h1 class="card-text"><?php echo $jumlah?></h1>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <?php
      };
    ?>

    <!-- Form -->
    <div class="container mt-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Daftar Balita</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nama Balita</th>
              <th scope="col">Tanggal Kunjungan</th>
              <th scope="col">Jenis Kelamin</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $nomor = 1;
              $sql2 = "SELECT * FROM daftar_balita_kader WHERE id_kader = $id_kader";
              $q2 = mysqli_query($koneksi,$sql2);

              while($r2 = mysqli_fetch_array($q2)){
                  $nama_balita   = $r2['nama_balita'];
                  $tanggal_kunjungan = $r2['tanggal_kunjungan'];
                  $jenis_kelamin = $r2['jenis_kelamin'];
                  $id_balita = $r2['id_balita'];

              ?>
            <tr>
              <th scope="row"><?php echo $nomor?></th>
              <td><?php echo $nama_balita ?></td>
              <td><?php echo $tanggal_kunjungan ?></td>
              <td><?php echo $jenis_kelamin ?></td>
              <td>
                <button class="btn btn-sm btn-info text-white"><a href="detailBalita.php?db=<?php echo $id_balita;?>" style="text-decoration: none;color: white ;">Detail</a></button>
                <button class="btn btn-sm btn-danger">Hapus</button>
              </td>
            </tr>

            <?php 
            $nomor++;
              };
            ?>
            <!-- Tambahkan baris lainnya sesuai kebutuhan -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


  </div>
</div>


</body>
</html>
