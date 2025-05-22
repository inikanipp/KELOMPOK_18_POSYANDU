<?php 
session_start();

require 'koneksi.php';

$sql1 = "select * from orang_tua";
$q1 = mysqli_query($koneksi, $sql1);

$sql2 = "select * from kader";
$q2 = mysqli_query($koneksi, $sql2);

$error = "";
$success = "";
$found = True;

if(isset($_POST['submit'])){
    if (isset($_POST["username"]) && isset($_POST["password"] )) {
    
        if($_POST["posisi"] == 'orangtua') {
            while($r1 = mysqli_fetch_array($q1)){
                $username1 = $r1['username'];
                $password1 = $r1['password'];
            
        
                $username = $_POST["username"];
                $password = $_POST["password"];
        
        
                if ($username == $username1 && $password==$password1){
                    
                    $_SESSION['login'] = True ;
                    $_SESSION["username"] = $username;
                    $_SESSION["id_ortu"] = $r1['id_ortu'];
                    $_SESSION["nama_ibu"] = $r1['nama_ibu'];
                    $found = True;
                    header("Location: ortu/index.php");
                    exit;
                }
        
            }
            if(!$found){
                $error = 'Akun Tidak Ditemukan boss';
            }
        };

        if($_POST['posisi']=='kader'){
            while($r1 = mysqli_fetch_array($q2)){
                $username1 = $r1['username'];
                $password1 = $r1['pw'];
                $status = $r1['status_kader'];
            
        
                $username = $_POST["username"];
                $password = $_POST["password"];
        
        
                if ($username == $username1 && $password==$password1 && $status=='Aktif'){
                    
                    $_SESSION['login'] = True ;
                    $_SESSION["username"] = $username;
                    $_SESSION["id_kader"] = $r1['id_kader'];
                    $found = True;
                    header("Location: ./kader/getKunjungan.php");
                    exit;
                }
                else{
                  echo "<script>
                          alert('Akun Tidak Aktif');
                          window.location.href = 'login.php';
                      </script>";
                }
        
            }
            if(!$found){
                $error = 'Akun Tidak Ditemukan boss';
            }
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
          <h1 class="mb-4 text-center" style="font-size: 35px; font-weight: bold;">Sign - In</h1>
          <form method="POST" class="d-flex flex-column gap-3">
            <input type="text" class="form-control" id="username" name="username" placeholder="username" style="background-color: #F0EFED;">
            <input type="password" class="form-control" id="password" name="password" placeholder="password" style="background-color: #F0EFED;">
            
            <select id="posisi" name="posisi" class="form-select mt-2">
              <option value="orangtua">Orang Tua</option>
              <option value="kader">Kader</option>
            </select>
            
            <div class="d-flex justify-content-center gap-2">
              <p class="mb-0" style="font-size: 14px;">Belum memiliki akun?</p>
              <a href="register.php" style="font-weight: 600; font-size: 14px; text-decoration: none;">Sign-Up</a>
            </div>

            <button type="submit" id="submit" name="submit" class="btn btn-primary rounded-5 mt-2" style="font-size: 18px;">Submit</button>
          </form>
        </div>
      </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></>
  </body>
</html>
