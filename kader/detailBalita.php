<?php
require '../koneksi.php';

$id_balita = $_GET['db'];


if (isset($_GET['db'])) {
    $id_balita = $_GET['db'];
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-info text-white">
            <h5 class="mb-0">Detail Balita</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- Kolom untuk detail data -->
                  <div class="col-md-8">
                    <dl class="row">
            <?php 
            $sql2 = "SELECT * FROM daftar_balita_kader WHERE id_balita = $id_balita";
            $q2 = mysqli_query($koneksi,$sql2);

            if($r2 = mysqli_fetch_array($q2)){
                $nama_balita   = $r2['nama_balita'];
                $tgl_lahir     = $r2['tgl_lahir'];
                $jenis_kelamin = $r2['jenis_kelamin'];
                $tanggal_kunjungan = $r2['tanggal_kunjungan'];
                $berat_badan   = $r2['berat_badan'];
                $tinggi_badan  = $r2['tinggi_badan'];
                $nama_imunisasi = $r2['nama_imunisasi'];
                $status_gizi   = $r2['status_gizi'];
            ?>
            <dt class="col-sm-4">Nama Balita</dt>
            <dd class="col-sm-8"><?php echo $nama_balita ?></dd>

            <dt class="col-sm-4">Tanggal Lahir</dt>
            <dd class="col-sm-8"><?php echo $tgl_lahir ?></dd>

            <dt class="col-sm-4">Jenis Kelamin</dt>
            <dd class="col-sm-8"><?php echo $jenis_kelamin ?></dd>

            <dt class="col-sm-4">Berat Badan</dt>
            <dd class="col-sm-8"><?php echo $berat_badan ?> kg</dd>

            <dt class="col-sm-4">Tinggi Badan</dt>
            <dd class="col-sm-8"><?php echo $tinggi_badan ?> cm</dd>

            <dt class="col-sm-4">Tanggal Kunjungan</dt>
            <dd class="col-sm-8"><?php echo $tanggal_kunjungan ?></dd>

            <dt class="col-sm-4">Imunisasi</dt>
            <dd class="col-sm-8"><?php echo $nama_imunisasi ?></dd>

            <dt class="col-sm-4">Status Gizi</dt>
            <dd class="col-sm-8"><?php echo $status_gizi ?></dd>

            <?php } ?>
            </dl>
            <a href="getKunjungan.php" class="btn btn-success">Kembali</a>
            </div>

            <!-- Kolom untuk gambar -->
            <div class="col-md-4 d-flex align-items-center justify-content-center">
              <img src="assets/img/<?php echo $jenis_kelamin; ?>.svg" alt="Gambar Jenis Kelamin" style="width : 40vh; height: auto;">
            </div>
          </div>
        </div>

        </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>