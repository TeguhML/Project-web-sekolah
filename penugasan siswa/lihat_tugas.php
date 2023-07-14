<?php
require_once('sambungkan.php');
require_once('hapus.php');

// Cek apakah ada permintaan untuk menampilkan detail tugas
if (isset($_GET['id'])) {
    $idTugas = $_GET['id'];

    // Ambil data tugas dari database (tabel t_upload)
    $query = "SELECT * FROM t_upload WHERE id = '$idTugas'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $tugas = mysqli_fetch_assoc($result);
        } else {
            echo "Tugas tidak ditemukan.";
            exit;
        }
    } else {
        echo "Gagal memuat tugas.";
        exit;
    }
} else {
    echo "ID Tugas tidak ditemukan.";
    exit;
}

$file = '';
if (!empty($tugas['file_path']) && file_exists($tugas['file_path'])) {
    $file = $tugas['file_path'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Detail Tugas</title>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-10 table-container">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center mb-0">Detail Tugas yang Sudah Dikumpulkan</h3>
            </div>
              <div class="card-body">
             <!-- Tampilkan informasi tugas -->
              <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" class="form-control" value="<?php echo $tugas['nama']; ?>" readonly />
              </div>
              
              <!-- Tampilkan informasi lainnya -->
              <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" id="nis" class="form-control" value="<?php echo $tugas['nis']; ?>" readonly />
              </div>

              <div class="form-group">
                <label for="mapel">Mata Pelajaran:</label>
                <?php
                // Ambil data mata pelajaran dari tabel t_mapel
                $idMapel = $tugas['id_mapel'];
                $query = "SELECT keterangan FROM t_mapel WHERE id_mapel = '$idMapel'";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    $mapel = mysqli_fetch_assoc($result)['keterangan'];
                    echo "<input type='text' class='form-control' value='$mapel' readonly>";
                } else {
                    echo "<input type='text' class='form-control' value='Tidak diketahui' readonly>";
                }
                ?>
              </div>

              <div class="form-group">
                <label for="jawaban">Jawaban:</label>
                <textarea id="jawaban" class="form-control" readonly><?php echo $tugas['jawaban']; ?></textarea>
              </div>

              <div class="form-group">
                <label for="file">File:</label>
              <?php if (!empty($file) && file_exists($file) && filesize($file) > 0): ?>
                <a href="<?php echo $file; ?>" target="_blank">Unduh File</a>
              <?php elseif (empty($tugas['file_path'])): ?>
                <p>File tidak terlampir.</p>
              <?php else: ?>
                <p>File tidak ditemukan.</p>
              <?php endif; ?>
            </div>

            <!-- Tombol Edit dan Hapus -->
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <p><a href="index.php?page=edit&id=<?php echo $idTugas; ?>" class="btn btn-outline-primary btn-sm mr-2">Edit</a>
                  <form action="" method="post" class="d-inline">
                  <input type="hidden" name="id_tugas" value="<?php echo $idTugas; ?>">
                  <button type="submit" name="hapus_tugas" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">Hapus</button></form>
                </p>
                <a href="index.php?page=penugasan" class="btn btn-secondary btn-block btn-back">Kembali</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
