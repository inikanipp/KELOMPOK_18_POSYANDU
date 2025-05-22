<?php
require '../koneksi.php';

$id_kader = $_GET['der'];
echo $id_kader;
if(isset($_POST['submit']) && isset($_GET['der']) ){
  echo "woii";
    if (isset($_POST["name"])) {

      
      try{
        $name = $_POST["name"];
        $berat_badan = $_POST["berat_badan"];
        $tinggi_badan = $_POST["tinggi_badan"];
        $jenis_imunisasi = $_POST["jenis_imunisasi"];
        $status = $_POST["status"];
        $date = $_POST["date"];
        $id_kader = $_GET['der'];
        $sql23 = "CALL add_kunjungan_kader($name, '$id_kader', '$date', $berat_badan, $tinggi_badan, '$status');";
        // $sql22 = "CALL addBalita('$name', $id_ortu, '$tgl_lahir','$jenis')";
        $q2 = mysqli_query($koneksi, $sql23);

        if ($q2) {
          echo "<script>alert('Data berhasil disimpan'); window.location.href='getKunjungan.php?der=$id_kader';</script>";
          exit;
        } else {
            echo "<script>alert('Gagal menyimpan data');</script>";
            echo "Error: " . mysqli_error($koneksi); // Tampilkan pesan error dari MySQL
        }
      } catch (mysqli_sql_exception $e) {
        $msg = $e->getMessage();
        echo "<script>alert('Gagal menambahkan balita: $msg'); window.location.href='index.php';</script>";
      }
      
  }
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
      /* display : none; */
      
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
      <a href="addKunjungan.php">Tambah Kunjungan</a>
    </div>
  </div>

 <!-- Content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col" style="height: 15vh;">
        <h1>Welcome Bunda !</h1>
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
    <div class="row">
      <div class="col overflow-auto" style="height: 60vh;">
        <div class="card">
          <div class="card-body">
            <form method='POST' action="?der=<?php echo $id_kader?>"> 
             <div class="mb-3">
                <label for="jenisKelamin" class="form-label">Nama Balita :</label>
                <select class="form-select" aria-label="Default select example" name="name">
                  <option selected value="null">-- Nama Balita --</option>
                  <?php 
                  $sql2 = "SELECT * FROM view_belum_imunisasi;";
                  $q2 = mysqli_query($koneksi,$sql2);

                  while($r2 = mysqli_fetch_array($q2)){
                      $id_balita   = $r2['id_balita'];
                      $nama_balita = $r2['nama_balita'];
                      $status = $r2['status'];
                      $nama_imunisasi = $r2['nama_imunisasi'];
                  ?>
                  <option value="<?php echo $id_balita; ?>"><?php echo "Nama : $nama_balita | Belum Imunisasi : $nama_imunisasi" ; ?></option>
                  <?php 
                  };
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="birthdate" class="form-label">Berat Badan :</label>
                <input type="number" class="form-control" id="beratBadan" name="berat_badan">
              </div>
              <div class="mb-3">
                <label for="birthdate" class="form-label">Tinggi Badan :</label>
                <input type="number" class="form-control" id="tinggiBadan" name="tinggi_badan">
              </div>
              <div class="mb-3">
                <label for="birthdate" class="form-label">Tanggal :</label>
                <input type="date" class="form-control" id="tinggiBadan" name="date">
              </div>
              <div class="mb-3">
                <label for="jenisKelamin" class="form-label">Status Gizi :</label>
                <select class="form-select" aria-label="Default select example" name="status">
                  <option selected value="null">-- Status Gizi --</option>
                  <option value="Baik">Baik</option>
                  <option value="Buruk">Buruk</option>
                  <option value="Kurang">Kurang</option>
                  <option value="Lebih">Lebih</option>
                </select>
              </div>
              <!-- <div class="mb-3">
                <label for="jenisKelamin" class="form-label">Imunisasi Saat ini :</label>
                <select class="form-select" aria-label="Default select example" name="jenis_imunisasi">
                  <option selected value="null">-- Pilih Imunisasi --</option>
                  <option value="Kurang">Kurang</option>
                </select>
              </div> -->
              <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>


</body>
</html>
