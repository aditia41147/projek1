<?php
// Konfigurasi database
$db_host = 'localhost';      // Host database
$db_user = 'root';           // Username MySQL
$db_pass = '';               // Password MySQL (kosongkan jika default)
$db_name = 'absennow';       // Nama database

// Buat koneksi ke database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Opsional: Hapus echo untuk keamanan di lingkungan produksi
// echo "Koneksi ke database berhasil!";
?>
