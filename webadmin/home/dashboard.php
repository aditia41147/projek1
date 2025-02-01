<?php
// Pastikan sesi aktif
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['full_name'])) {
    header("Location: ../home/login.php");
    exit();
}

// Ambil nama pengguna dari sesi
$full_name = $_SESSION['full_name'];

// Koneksi ke database
include '../config/koneksi.php';

// Hitung jumlah pegawai
$query = "SELECT COUNT(*) AS jumlah_pegawai FROM users";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$jumlah_pegawai = $data['jumlah_pegawai'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Sidebar -->
    <?php include 'menuadmin.php'; ?>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Selamat Datang, <?php echo $full_name; ?></h1>
        <div class="stats-container">
            <div class="stat-box">
                <h3><?php echo $jumlah_pegawai; ?></h3>
                <p>Jumlah Pegawai & Guru</p>
            </div>
        </div>
    </div>
</body>
</html>
