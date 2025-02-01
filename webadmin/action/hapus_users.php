<?php
// Koneksi ke database
include '../../config/koneksi.php';

// Periksa apakah phone_number dikirim melalui URL
$phone_number = $_GET['phone_number'] ?? '';

if (empty($phone_number)) {
    echo "<script>alert('Phone Number tidak ditemukan!'); window.location.href = '../datapegawai.php';</script>";
    exit;
}

// Query untuk menghapus data user berdasarkan phone_number
$sql = "DELETE FROM users WHERE phone_number = '$phone_number'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('User berhasil dihapus!'); window.location.href = '../datapegawai.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

// Tutup koneksi
$conn->close();
?>
