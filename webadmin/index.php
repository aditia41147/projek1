<?php
// Mulai sesi jika diperlukan
session_start();

// Include koneksi database
include 'config/koneksi.php';

// Include daftar menu dari content.php
include 'config/content.php';

// Ambil route dari URL, default ke 'dashboard' jika tidak ada
$route = isset($_GET['route']) ? $_GET['route'] : 'dashboard';

// Cek apakah route terdaftar di daftar menu
if (array_key_exists($route, $menus)) {
    // Include file sesuai route
    include $menus[$route];
} else {
    // Jika route tidak ditemukan, tampilkan halaman 404
    echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
}
