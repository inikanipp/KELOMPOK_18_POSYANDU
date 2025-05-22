<?php
require '../koneksi.php';

$id_ortu = $_GET['do'];

if(isset($_POST['submit']) && isset($_GET['do']) ){
    if (isset($_POST["name"]) && isset($_POST["jenis"] ) && isset($_POST["tgl_lahir"])) {
      $name = $_POST["name"];
      $jenis = $_POST["jenis"];
      $tgl_lahir = $_POST["tgl_lahir"];
      $id_ortu = $_GET['do'];

      try{
        $sql22 = "CALL addBalita('$name', $id_ortu, '$tgl_lahir','$jenis')";
        $q2 = mysqli_query($koneksi, $sql22);

        if ($q2) {
          echo "<script>alert('Data berhasil disimpan'); window.location.href='index.php';</script>";
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
          <li><a href="formAdd.php?do=<?php echo $id_ortu?>">Add Balita</a></li>
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
              <h3>Informasi Kontak</h3>
              <p>Posyandu siap melayani kebutuhan kesehatan ibu dan anak. Jangan ragu untuk menghubungi kami atau datang langsung ke lokasi kami.</p>

              <div class="info-item">
                <div class="icon-box">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="content">
                  <h4>Lokasi Kami</h4>
                  <p>Jl. Melati No. 108,</p>
                  <p>Kelurahan Sehat, Kecamatan Damai</p>
                </div>
              </div>

              <div class="info-item">
                <div class="icon-box">
                  <i class="bi bi-telephone"></i>
                </div>
                <div class="content">
                  <h4>Nomor Telepon</h4>
                  <p>+62 812 3456 7890</p>
                  <p>+62 813 9876 5432</p>
                </div>
              </div>

              <div class="info-item">
                <div class="icon-box">
                  <i class="bi bi-envelope"></i>
                </div>
                <div class="content">
                  <h4>Email Address</h4>
                  <p>posyandu@sehat.id</p>
                  <p>kontak@posyandu.id</p>
                </div>
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
                  <form method='POST' action="?do=<?php echo $id_ortu;?>">                      
                      <div class="mb-3">
                          <label for="name" class="form-label" >Nama Balita : </label>
                          <input type="text" class="form-control" id="name" name="name">
                      </div>
                      <div class="mb-3">
                          <label for="name" class="form-label" >Tanggal Lahir : </label>
                          <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                      </div>
                      <div class="mb-3">
                          <label for="jenisKelamin" class="form-label">Jenis Kelamin : </label>
                          <select class="form-select" aria-label="Default select example" name="jenis">
                              <option selected value="null">-- jenis kelamin --</option>
                              <option value="Laki-laki">Laki-laki</option>
                              <option value="Perempuan">Perempuan</option>
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