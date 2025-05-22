<?php
require '../koneksi.php';


$nama_balita = "";
$dit = $_GET['dit'];

if (isset($_GET['dit'])){
  $dit = $_GET['dit'];
  
 
  $id_balita = $_GET['dit'];


  $sql3 = "SELECT * FROM balita WHERE id_balita = $id_balita";
  
  $q2 = mysqli_query($koneksi,$sql3);

  if($r2 = mysqli_fetch_array($q2)){
    $nama_balita   = $r2['nama_balita'];
    $tgl_lahir   = $r2['tgl_lahir'];
    $jenis_kelamin   = $r2['jenis_kelamin'];             
  }

}

if(isset($_POST['submit'])){
  $nama_balita =  $_POST['name'];
  $tgl =  $_POST['tgl'];
  $jenis =  $_POST['jenis'];
  $sql23 = "CALL update_balita('$nama_balita', '$tgl','$jenis', $dit)";
  $q2 = mysqli_query($koneksi,$sql23);

  if($q2){
    echo "<script>
          alert('Data berhasil diperbarui!');
          window.location.href = 'index.php';
        </script>";
    exit;
  }

  else{
      $error = "gagal membuat akun";
      echo $error;
  }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Posyandu</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body>
    <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">Ambasyandu</h1>
      </a>

      <nav id="navmenu" class="navmenu d-flex justify-content-end">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="?dit=<?php echo $id_balita; ?>">Add Balita</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      

    </div>
  </header>

     <!-- Contact Section -->
    <section id="contact" class="contact section light-background mt-5">
      
      <!-- Section Title -->
      <div class="container section-title">
        <h2>Data Diri Balitamu</h2>
        <p>Yukk Isi Form Data Diri Balitamu</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row g-4 g-lg-5">
          <div class="col-lg-5">
            <div class="info-box">
              <h3>Riwayat Imunisasi</h3>
              <div class="container" style="overflow-y: scroll; height: 70vh;">

                <?php 

                $sql2 = "SELECT * FROM view_imunisasi_balita WHERE id_balita = $id_balita";

                $q2 = mysqli_query($koneksi,$sql2);
                while($r2 = mysqli_fetch_array($q2)){
                  $nama_imunisasi   = $r2['nama_imunisasi'];
                  $id_balita   = $r2['id_balita'];
                  $tgl_kunjungan = $r2['tanggal_kunjungan'];
                  $berat_badan = $r2['berat_badan'];
                  $tinggi_badan = $r2['tinggi_badan'];
                  ?>  

                <!-- start card  -->
                <div class="row mb-3">
                  <div class="col">
                    <div class="card" style="width: 18rem;">
                      <div class="card-body">
                        <h5 class="card-title">Imunisasi <?php echo $nama_imunisasi;?></h5>
                        <p class="card-text"><?php echo $tgl_kunjungan;?></p>
                        <p class="card-text">berat badan : <?php echo $berat_badan;?></p>
                        <p class="card-text">tinggi badan : <?php echo $tinggi_badan;?></p>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end card -->
                <?php 
                };
                ?>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="contact-form">
              <h3>Formulir Data Diri</h3>
              <p>yukk isi/perbaiki data diri balitamu</p>

               <!-- start card balitaa -->

              <div class="card" id="form">
                  <div class="card-body">
                  <form method='POST' action="?dit=<?php echo $id_balita; ?>">
                      <div class="mb-3">
                          <label for="name" class="form-label">Nama Balita : </label>
                          <input type="text" class="form-control" id="name" name="name" value="<?php echo $nama_balita; ?>">
                      </div>
                      <div class="mb-3">
                          <label for="name" class="form-label">Tanggal Lahir : </label>
                          <input type="date" class="form-control" id="tgl" name="tgl" value="<?php echo $tgl_lahir; ?>">
                      </div>
                      <div class="mb-3">
                          <label for="jenisKelamin" class="form-label">Jenis Kelamin : </label>
                          <select class="form-select" aria-label="Default select example" name="jenis">
                              <option selected value="null">-- jenis kelamin --</option>
                              <option value="Laki-laki" <?php if ($jenis_kelamin == "Laki-laki") echo "selected"; ?>>Laki-laki</option>
                              <option value="Perempuan" <?php if ($jenis_kelamin == "Perempuan") echo "selected"; ?> >Perempuan</option>
                          </select>
                      </div>
                      
                      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                  </form>
                  </div>
              </div>
              
            <!-- end card balitaa -->

            </div>
          </div>

        </div>

      </div>

    </section><!-- /Contact Section -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>