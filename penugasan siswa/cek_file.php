<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "uploads/";
    // Direktori tujuan penyimpanan file (pastikan path yang benar)
    $fileTugas = $_FILES['file'];

    $fileName = $fileTugas['name'];
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (!empty($fileName)) {
        $allowTypes = array('pdf', 'doc', 'docx');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($fileTugas['tmp_name'], $targetFilePath)) {
                echo "File berhasil diunggah.";
                // Lakukan operasi lain yang Anda perlukan setelah file diunggah
            } else {
                echo "Gagal mengunggah file.";
            }
        } else {
            echo "Format file tidak valid. Hanya file PDF, DOC, dan DOCX yang diperbolehkan.";
        }
    } else {
        echo "File tidak ditemukan.";
    }
}

?>
