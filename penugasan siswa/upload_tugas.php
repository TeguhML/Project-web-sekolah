<?php
include "sambungkan.php";

// Periksa koneksi ke database
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Inisialisasi variabel pesan error
$error = '';
$idTugas = '';

// Cek permintaan pengiriman tugas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $nis = $_POST['nis'];
    $mapel = $_POST['mapel'];
    $jawaban = $_POST['jawaban'];

    // Periksa apakah nama, NIS, dan Mata Pelajaran sudah diisi
    if (empty($nama) || empty($nis) || empty($mapel)) {
        $error = 'Nama, NIS, dan Mata Pelajaran harus diisi.';
    } else {
        // Ambil data lainnya dari form
        $jawaban = $_POST['jawaban'];

        // Lakukan operasi penyimpanan file
        $targetDir = "uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Periksa apakah file yang diunggah valid
        if (!empty($fileName)) {
            $allowTypes = array('pdf', 'doc', 'docx');
            if (in_array($fileType, $allowTypes)) {
                // Pindahkan file ke folder tujuan
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                    // Simpan informasi file ke database
                    $query = "INSERT INTO t_upload (nama, nis, id_mapel, jawaban, file_path) VALUES ('$nama', '$nis', '$mapel', '$jawaban', '$targetFilePath')";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        // Mendapatkan ID tugas yang baru saja diunggah
                        $idTugas = mysqli_insert_id($conn);
                    } else {
                        // Menambahkan logika tambahan atau pesan error di sini
                        echo "Gagal mengunggah tugas.";
                    }
                } else {
                    // File gagal diunggah, Anda dapat menambahkan logika tambahan atau pesan error di sini
                    echo "Gagal mengunggah file.";
                }
            } else {
                // Format file tidak valid, Anda dapat menambahkan logika tambahan atau pesan error di sini
                echo "Format file tidak valid. Hanya file PDF, DOC, dan DOCX yang diperbolehkan.";
            }
        } else {
            // File tidak ditemukan, Anda dapat menambahkan logika tambahan atau pesan error di sini
            echo "File tidak ditemukan.";

            // Simpan informasi file ke database tanpa file_path (NULL)
           $query = "INSERT INTO t_upload (nama, nis, id_mapel, jawaban, file_path) VALUES ('$nama', '$nis', '$mapel', '$jawaban', '$targetFilePath')";

            $result = mysqli_query($conn, $query);
            if (!$result) {
              echo "Error: " . mysqli_error($conn);
          }
          

            if ($result) {
                // Mendapatkan ID tugas yang baru saja diunggah
                $idTugas = mysqli_insert_id($conn);
            } else {
                // Menambahkan logika tambahan atau pesan error di sini
                echo "Gagal mengunggah tugas.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Upload File</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
    
      </div>
    </div>
    <div class="row justify-content-center mt-5  ">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header ">
            <h3 class="text-center col-md-12">Upload Tugas</h3>
          </div>
          <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
              
              <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" class="form-control" name="nama" required />
              </div>

              <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" id="nis" class="form-control" name="nis" required />
              </div>

              <div class="form-group">
                <label for="mapel">Mata Pelajaran:</label>
                <select id="mapel" class="form-control" name="mapel">
                  <option value="">Pilih Mata Pelajaran</option>
                  <?php
                  // Ambil data mata pelajaran dari tabel t_mapel
                  $query = "SELECT * FROM t_mapel";
                  $result = mysqli_query($conn, $query);

                  // Buat opsi dropdown berdasarkan data yang diambil
                  while ($row = mysqli_fetch_assoc($result)) {
                    $idMapel = $row['id_mapel'];
                    $namaMapel = $row['keterangan'];

                    // Tampilkan opsi dropdown
                    echo "<option value=\"$idMapel\">$namaMapel</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="jawaban">Jawaban:</label>
                <textarea id="jawaban" class="form-control" name="jawaban"></textarea>
              </div>

              <div class="form-group">
                <label for="file-input">File: PDF, DOC, dan DOCX</label>
                <input type="file" name="file" id="file-input" class="form-control-file" />
              </div>

              <?php if (!empty($idTugas)): ?>
                <p class="description">Tugas berhasil dikumpulkan</p>
                  <a href="index.php?page=lihat_tugas&id=<?php echo $idTugas; ?>" class="btn btn-info btn-sm ">Lihat Tugas</a>
              </p>
                <?php endif; ?>

              <div class="button-group">
                <button type="submit" class="btn btn-primary btn-block btn-upload">Upload</button>
                <a href="index.php?page=penugasan" class="btn btn-secondary btn-block btn-back ">Kembali</a>
              </div>
              
              <?php if (!empty($error)): ?>
                <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
              <?php endif; ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
</body>
</html>
