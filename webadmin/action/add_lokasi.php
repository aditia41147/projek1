<?php
// Koneksi ke database
include '../config/koneksi.php';

// Cek apakah form telah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {=
    $name_lokasi = $_POST['name_lokasi'];
    $location = $_POST['location'];
    $area_login = $_POST['area_login'];

    // Validasi data
    if ( !empty($name_lokasi) && !empty($location) && !empty($area_login)) {
        // Query untuk menambahkan data ke tabel lokasi
        $sql = "INSERT INTO lokasi ( name_lokasi, location, area_login) 
                VALUES ( '$name_lokasi', '$location', '$area_login')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Lokasi berhasil ditambahkan!'); window.location.href = '../home/lokasipresensi.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('Semua field harus diisi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #3498db;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #2980b9;
        }
        .btn-cancel {
            background-color: #e74c3c;
            margin-top: 10px;
        }
        .btn-cancel:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Tambah Lokasi</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name_lokasi">Nama Lokasi</label>
                <input type="text" id="name_lokasi" name="name_lokasi" required>
            </div>
            <div class="form-group">
                <label for="location">Lokasi</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="area_login">Area Login</label>
                <input type="number" id="area_login" name="area_login" required>
            </div>
            <div class="form-group">
                <button type="submit">Proses</button>
            </div>
            <div class="form-group">
                <a href="lokasipresensi.php" class="btn-cancel" style="display: block; text-align: center; padding: 10px; text-decoration: none; color: white;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
