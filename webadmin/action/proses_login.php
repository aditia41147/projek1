<?php
include '../config/koneksi.php';

// Ambil data dari form
$phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
$password = md5(mysqli_real_escape_string($conn, $_POST['password'])); // Enkripsi password dengan MD5

// Query untuk memeriksa data login berdasarkan nomor telepon dan password MD5
$query = "SELECT * FROM users WHERE phone_number = '$phone_number' AND password = '$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Login berhasil
    session_start();
    $row = mysqli_fetch_assoc($result);
    $_SESSION['phone_number'] = $row['phone_number'];
    $_SESSION['full_name'] = $row['full_name'];
    header("Location: ../home/dashboard.php");
    exit();
} else {
    // Login gagal
    echo "<script>alert('Nomor Telepon atau Password salah!'); window.location='../home/login.php';</script>";
}
?>
