<?php 
require '../koneksi.php';


session_start();

if (!isset($_SESSION['nama_ibu'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: ../login.php");
    exit();
}

if(isset($_SESSION['username'])){
  $username = $_SESSION['nama_ibu'];
  $id_ortu = $_SESSION["id_ortu"];
}

if (isset($_GET['del'])){
  $del = $_GET['del'];

  try {
        $sql = "CALL delete_balita($del)";
        mysqli_query($koneksi, $sql);
        echo "<script>alert('Data balita berhasil dihapus'); window.location.href='index.php';</script>";
    } catch (mysqli_sql_exception $e) {
        $msg = $e->getMessage();
        echo "<script>alert('Gagal menghapus balita: $msg'); window.location.href='index.php';</script>";
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

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">halo bunda <?php echo $username?></h1>
      </a>

      <nav id="navmenu" class="navmenu d-flex justify-content-end">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="formAdd.php?do=<?php echo $id_ortu?>">Add Balita</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content">
              <h1 class="mb-4">
                Yukk Cek <br>
                Kesehatan Balita anda <br>
                <span class="accent-text">di Ambasyandu</span>
              </h1>
              <p class="mb-4 mb-md-5">
                Melalui kunjungan rutin ke posyandu, orang tua dapat memperoleh imunisasi, vitamin, serta penyuluhan gizi dan kesehatan secara gratis. 
              </p>
              <div class="hero-buttons">
                <a href="formAdd.php?do=<?php echo $id_ortu?>" class="btn btn-primary me-0 me-sm-2 mx-1">Tambah Balita</a>

              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="hero-image">
              <img src="assets/img/rafiki.svg" alt="Hero Image" class="img-fluid">              
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

    <!-- Services Section -->
    <section id="services" class="services section light-background">

      <!-- Section Title -->
      <div class="container section-title">
        <h2>Daftar Balitamu</h2>
        <p>Yukk Cek Daftar nama Balitamu</p>
      </div><!-- End Section Title -->

      <div class="container" style="height: 40dvh; overflow-y: auto;">

        <?php 
        $sql2 = "SELECT * FROM view_umur_balita where id_ortu = $id_ortu;";
        $q2 = mysqli_query($koneksi,$sql2);

        while($r2 = mysqli_fetch_array($q2)){
            $nama_balita   = $r2['nama_balita'];
            $umur = $r2['umur'];
            $jenis_kelamin = $r2['jenis_kelamin'];
            $id_balita = $r2['id_balita'];

        ?>
        <!-- cardd start -->
        <div class="service-card d-flex mt-2">
            <div class="me-5">
              <img src="assets/img/<?php echo $jenis_kelamin; ?>.svg" alt="Gambar Jenis Kelamin" style="width: 60px;">
            </div>
            <div>
              <h3><?php echo $nama_balita ?></h3>
              <p>Jenis Kelamin : <?php echo $jenis_kelamin?></p>
              <p>Umur : <?php echo $umur ?> bulan</p>
              <a href="form.php?dit=<?php echo $id_balita?>" class="btn btn-primary">Detail</a>
              <a href="index.php?del=<?php echo $id_balita?>" class="btn btn-danger">Delete</a>
            </div>
        </div>
        <!-- cardd end -->
        <?php 
        };
        
        ?>
      </div>
    </section><!-- /Services Section -->




   

  </main>
  <footer class="d-flex justify-content-center">
    @2023 Ambasyandu
  </footer>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>