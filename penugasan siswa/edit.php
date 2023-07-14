<?php
require_once('sambungkan.php');

// Cek apakah ada permintaan untuk mengedit tugas
if (isset($_GET['id'])) {
    $idTugas = $_GET['id'];

    // Ambil data tugas dari database (tabel t_upload) berdasarkan ID tugas yang dikirim
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

// Inisialisasi variabel pesan error
$error = '';

// Cek permintaan pengiriman perubahan tugas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $jawaban = $_POST['jawaban'];

    // Periksa apakah nama, NIS, dan jawaban tidak kosong
    if (empty($nama) || empty($nis) || empty($jawaban)) {
        $error = 'Nama, NIS, dan Jawaban harus diisi.';
    } else {
        // Lakukan operasi update data tugas
        $query = "UPDATE t_upload SET nama = '$nama', nis = '$nis', jawaban = '$jawaban' WHERE id = '$idTugas'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Periksa apakah file tugas diunggah
            if (!empty($_FILES['upload']['name'])) {
                $targetDir = "uploads/";
                $fileName = basename($_FILES["upload"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = strtolower(ltrim(pathinfo($targetFilePath, PATHINFO_EXTENSION), '.'));


                // Periksa apakah file yang diunggah valid
                $allowTypes = array('pdf', 'doc', 'docx');
                if (in_array($fileType, $allowTypes)) {
                    // Hapus file tugas sebelumnya jika ada
                    if (!empty($tugas['file_path'])) {
                        unlink($tugas['file_path']);
                    }

                    // Pindahkan file tugas baru ke folder tujuan
                    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $targetFilePath)) {
                        // Update path file tugas di database
                        $query = "UPDATE t_upload SET file_path = '$targetFilePath' WHERE id = '$idTugas'";
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            echo "Gagal mengupdate path file tugas.";
                            exit;
                        }
                    } else {
                        echo "Gagal mengunggah file tugas.";
                        exit;
                    }
                } else {
                    echo "Format file tidak valid. Hanya file PDF, DOC, dan DOCX yang diperbolehkan.";
                    exit;
                }
            }

            // Mengirimkan pengguna ke lihat_tugas.php dengan ID tugas yang sudah diperbarui
            echo '<script>alert("Tugas berhasil diupdate."); window.location.href = "index.php?page=lihat_tugas&id=' . $idTugas . '";</script>';
            exit;
        } else {
            echo "Gagal mengupdate tugas.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Edit Tugas</title>
</head>
<body>
  <div class="row justify-content-center mt-5">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">
          <h3 class="text-center mb-0">Edit Tugas</h3>
        </div>
        <div class="card-body">
          <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="nama">Nama:</label>
              <input type="text" id="nama"class="form-control" name="nama" value="<?php echo $tugas['nama']; ?>" required />
            </div>

            <div class="form-group">
              <label for="nis">NIS:</label>
              <input type="text" id="nis" class="form-control" name="nis" value="<?php echo $tugas['nis']; ?>" required />
            </div>

            <div class="form-group">
              <label for="jawaban">Jawaban:</label>
              <textarea id="jawaban" class="form-control" name="jawaban" required><?php echo $tugas['jawaban']; ?></textarea>
            </div>

            <div class="form-group">
             
              <?php
// Periksa apakah file tugas saat ini ada atau tidak
$fileExists = !empty($tugas['file_path']) && file_exists($tugas['file_path']);

// Pesan jika file tidak ada
$fileMessage = 'Tidak ada file yang terlampir.';
?>

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

<div class="form-group">
    <label for="upload">Unggah File:</label>
    <input type="file" id="upload" name="upload" class="form-control-file">
</div>

            <div class="btn-update">
              <button type="submit" class="btn btn-primary btn-block">Update Tugas</button>
              <a href="index.php?page=lihat_tugas&id=<?php echo $idTugas; ?>" class="btn btn-secondary btn-block btn-back">Kembali</a>
            </div>

            <?php if (!empty($error)): ?>
              <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
