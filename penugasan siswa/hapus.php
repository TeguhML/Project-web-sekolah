<?php
require_once('sambungkan.php');

// Fungsi untuk menghapus tugas berdasarkan ID
function hapusTugas($conn, $id, $hapusFile = false) {
    // Periksa apakah ada file yang terlampir
    $query = "SELECT file_path FROM t_upload WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $filePath = $row['file_path'];

        if (!empty($filePath) && file_exists($filePath) && $hapusFile) {
            unlink($filePath);
        }
    }

    // Hapus data tugas dari tabel t_upload
    $query = "DELETE FROM t_upload WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return true;
    } else {
        echo "Gagal menghapus tugas.";
    }

    return false;
}

// Periksa apakah ada permintaan untuk menghapus tugas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_tugas']) && isset($_POST['id_tugas'])) {
    $idTugas = $_POST['id_tugas'];

    if (hapusTugas($conn, $idTugas)) {
        echo '<script>alert("Tugas berhasil dihapus."); window.location.href = "index.php?page=penugasan";</script>';
        exit;
    } else {
        echo "Gagal menghapus tugas.";
    }
}
?>
