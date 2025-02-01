<?php
// Koneksi ke database
include '../config/koneksi.php';

// Periksa apakah id_lokasi dikirim melalui URL
$id_lokasi = $_GET['id_lokasi'] ?? '';

if (empty($id_lokasi)) {
    echo "<script>alert('ID Lokasi tidak ditemukan!'); window.location.href = '../home/lokasipresensi.php';</script>";
    exit;
}

// Query untuk menghapus data lokasi
$sql = "DELETE FROM lokasi WHERE id_lokasi = '$id_lokasi'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Lokasi berhasil dihapus!'); window.location.href = '../home/lokasipresensi.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

// Tutup koneksi
$conn->close();
?>
