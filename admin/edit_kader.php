<?php
include '../koneksi.php';
$id = $_GET['id'];
$result = $koneksi->query("SELECT * FROM kader WHERE id_kader = '$id'");
$data = $result->fetch_assoc();

$error_message = '';
$nama = $data['nama_kader'];
$jabatan = $data['jabatan'];
$byk_anak = $data['byk_anak'];
$no_hp = $data['no_hp'];
$username = $data['username'];
$password = $data['pw'];
$status = $data['status_kader'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_kader'];
    $jabatan = $_POST['jabatan'];
    $byk_anak_input = $_POST['byk_anak'];
    $no_hp = $_POST['no_hp'];
    $username = $_POST['username'];
    $password = $_POST['pw'];
    $status = $_POST['status_kader'];

    $byk_anak = ($byk_anak_input === '') ? null : (int)$byk_anak_input;

    $stmt = $koneksi->prepare("CALL sp_update_kader(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ississss", $id, $nama, $jabatan, $byk_anak, $no_hp, $username, $password, $status);

    try {
        if ($stmt->execute()) {
            header("Location: data_kader.php");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $error_message = $e->getMessage();
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <title>Edit Kader</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    <?php if (!empty($error_message)): ?>
      alert("<?= htmlspecialchars($error_message, ENT_QUOTES) ?>");
    <?php endif; ?>
  </script>
</head>
<body class="p-4">
  <div class="container">
    <h3>Edit Data Kader</h3>
    <form method="post">
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="text" name="pw" value="<?= htmlspecialchars($password) ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label>Nama Kader</label>
        <input type="text" name="nama_kader" value="<?= htmlspecialchars($nama) ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label>Jabatan</label>
        <input type="text" name="jabatan" value="<?= htmlspecialchars($jabatan) ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label>Banyak Anak</label>
        <input type="number" name="byk_anak" value="<?= htmlspecialchars($byk_anak ?? '') ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label>No HP</label>
        <input type="text" name="no_hp" value="<?= htmlspecialchars($no_hp) ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label>Status</label>
        <select name="status_kader" class="form-control">
          <option value="" <?= $status === '' ? 'selected' : '' ?>>Silakan Pilih</option>
          <option value="Aktif" <?= $status === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
          <option value="Nonaktif" <?= $status === 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="data_kader.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</body>
</html>
