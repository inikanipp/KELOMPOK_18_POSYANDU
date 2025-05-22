<?php 
session_start();
require 'koneksi.php';

$error = "";
$success = "";

if(isset($_POST['submit'])){
    $nama_ayah = $_POST['nama_ayah'];
    $nama_ibu = $_POST['nama_ibu'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username sudah digunakan
    $check = mysqli_query($koneksi, "SELECT * FROM orang_tua WHERE username = '$username'");
    if(mysqli_num_rows($check) > 0){
        $error = "Username sudah digunakan";
    } else {
        // Simpan ke database
        $sql = "INSERT INTO orang_tua (nama_ayah, nama_ibu, alamat, no_hp, username, password) 
                VALUES ('$nama_ayah', '$nama_ibu', '$alamat', '$no_hp', '$username', '$password')";
        $query = mysqli_query($koneksi, $sql);

        if($query){
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;

            // Ambil id orang tua
            $get_id = mysqli_query($koneksi, "SELECT LAST_INSERT_ID() AS id_ortu");
            $id = mysqli_fetch_assoc($get_id)['id_ortu'];
            $_SESSION['id_ortu'] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["nama_ibu"] = $nama_ibu;

            header("Location: ortu/index.php");
            exit;
        } else {
            $error = "Gagal menyimpan data";
        }
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Responsive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
      .img img {
        width: 100%;
        height: auto;
        object-fit: contain;
      }
    </style>
  </head>
  <body class="min-vh-100">
    <div class="container-fluid min-vh-100 d-flex flex-column flex-md-row">
      
      <!-- Left Section (Gambar) -->
      <div class="col-12 col-md-6 d-flex justify-content-center align-items-center order-1 order-md-1 p-3">
        <div class="img rounded-4 w-100" style="background-color: #F0EFED;">
          <img src="./assets/rafiki.svg" alt="Ilustrasi" class="img-fluid p-3">
        </div>
      </div>

      <!-- Right Section (Form) -->
      <div class="col-12 col-md-6 d-flex justify-content-center align-items-center order-2 order-md-2 p-3">
        <div class="rounded-4 p-4 w-100" style="max-width: 400px;">
          <h1 class="mb-4 text-center" style="font-size: 35px; font-weight: bold;">Sign - Up</h1>
          <form method="POST" action="">
            <div class="row">
              <div class="col-md-6">
                <label for="namaAyah" class="form-label">Nama Ayah</label>
                <input type="text" class="form-control" id="namaAyah" name="nama_ayah" required />
              </div>
              <div class="col-md-6">
                <label for="namaIbu" class="form-label">Nama Ibu</label>
                <input type="text" class="form-control" id="namaIbu" name="nama_ibu" required />
              </div>
            </div>

            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control mb-3" id="alamat" name="alamat" required />

            <div class="row">
              <div class="col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required />
              </div>
              <div class="col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required />
              </div>
            </div>

            <label for="telepon" class="form-label mt-3">Nomor Telp</label>
            <input type="text" class="form-control mb-4" id="telepon" name="no_hp" required />

            <div class="text-center">
              <button type="submit" name="submit" class="btn btn-primary">Sign Up</button>
            </div>
          </form>

        </div>
      </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
