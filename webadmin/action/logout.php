<?php
// Mulai sesi
session_start();

// Hapus semua data sesi
session_unset();
session_destroy();

// Redirect ke halaman login
header("Location: ../home/login.php");
exit();
?>
