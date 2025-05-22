<?php
include '../koneksi.php';
$error_message = '';
$nama = $jabatan = $no_hp = $status = $username = $password = '';
$byk_anak = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_kader'];
    $jabatan = $_POST['jabatan'];
    $no_hp = $_POST['no_hp'];
    $byk_anak_input = $_POST['byk_anak'];
    $username = $_POST['username'];
    $password = $_POST['pw'];
    $status = $_POST['status_kader'];
    try {
        $byk_anak = ($byk_anak_input === '') ? null : (int)$byk_anak_input;

        $stmt = $koneksi->prepare("INSERT INTO kader (username, pw, nama_kader, jabatan, byk_anak, no_hp, status_kader) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $username, $password, $nama, $jabatan, $byk_anak, $no_hp, $status);

        if ($stmt->execute()) {
            header("Location: data_kader.php");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $error_message = $e->getMessage();
    }

    
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <title>Tambah Kader</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    <?php if (!empty($error_message)): ?>
      alert("<?= htmlspecialchars($error_message, ENT_QUOTES) ?>");
    <?php endif; ?>
  </script>
</head>
<body class="p-4">
  <div class="container">
    <h3>Tambah Kader Baru</h3>
    <form method="post">
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>">
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="text" name="pw" class="form-control" value="<?= htmlspecialchars($password) ?>">
      </div>
      <div class="mb-3">
        <label>Nama Kader</label>
        <input type="text" name="nama_kader" class="form-control" value="<?= htmlspecialchars($nama) ?>">
      </div>
      <div class="mb-3">
        <label>Jabatan</label>
        <select name="jabatan" class="form-control">
          <option value="" <?= $jabatan === '' ? 'selected' : '' ?>>Silahkan Pilih</option>
          <option value="Ketua" <?= $jabatan === 'Ketua' ? 'selected' : '' ?>>Ketua</option>
          <option value="Sekretaris" <?= $jabatan === 'Sekretaris' ? 'selected' : '' ?>>Sekretaris</option>
          <option value="Bendahara" <?= $jabatan === 'Bendahara' ? 'selected' : '' ?>>Bendahara</option>
          <option value="Anggota" <?= $jabatan === 'Anggota' ? 'selected' : '' ?>>Anggota</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Banyak Anak</label>
        <input type="number" name="byk_anak" class="form-control" value="<?= htmlspecialchars($byk_anak ?? '') ?>">
      </div>
      <div class="mb-3">
        <label>No HP</label>
        <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($no_hp) ?>">
      </div>
      <div class="mb-3">
        <label>Status</label>
        <select name="status_kader" class="form-control">
          <option value="" <?= $status === '' ? 'selected' : '' ?>>Silahkan Pilih</option>
          <option value="Aktif" <?= $status === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
          <option value="Nonaktif" <?= $status === 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
        </select>
      </div>
      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="data_kader.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</body>
</html>
