<?php
include 'koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['usn'];
    $password = $_POST['password'];
    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id_admin FROM admin WHERE username = ? AND password = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Berhasil login'); window.location.href='./admin/dashboard.php';</script>";
        } else {
            echo "<script>alert('Username atau password salah'); window.location.href='login_admin.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Username dan password tidak boleh kosong'); window.location.href='login_admin.php';</script>";
    }
    $koneksi->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #d6e87a;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
      background-color: #ffffff;
      border: none;
      border-radius: 16px;
    }

    .btn-primary {
      background-color: #ec407a;
      border: none;
    }

    .btn-primary:hover {
      background-color: #d81b60;
    }

    h3 {
      color: #ec407a;
    }

    .form-label {
      color: #333;
    }

    .form-control:focus {
      border-color: #ec407a;
      box-shadow: 0 0 0 0.2rem rgba(236, 64, 122, 0.25);
    }

    .object-fit-cover {
      object-fit: cover;
    }
  </style>
</head>
<body>
  <section class="p-3 p-md-4 p-xl-5">
    <div class="container">
      <div class="card shadow-sm">
        <div class="row g-0">
          <div class="col-12 col-md-6">
            <img class="img-fluid rounded-start w-90 h-90 object-fit-cover" loading="lazy" src="./admin/assets/POSYANDU.png" alt="Logo Posyandu">
          </div>
          <div class="col-12 col-md-6 d-flex align-items-center">
            <div class="card-body p-3 p-md-4 p-xl-5">
              <div class="mb-5">
                <h3>Silahkan Login Disini</h3>
              </div>
              <form action="" method="post">
                <div class="row gy-3 gy-md-4 overflow-hidden">
                  <div class="col-12">
                    <label for="usn" class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="usn" id="usn" placeholder="Masukkan Username" required>
                  </div>
                  <div class="col-12">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" id="password" required>
                  </div>
                  <div class="col-12">
                    <div class="d-grid">
                      <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
