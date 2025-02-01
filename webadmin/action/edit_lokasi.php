<?php
// Koneksi ke database
include '../config/koneksi.php';

// Ambil id_lokasi dari URL
$id_lokasi = $_GET['id_lokasi'] ?? '';

// Periksa apakah id_lokasi ada
if (empty($id_lokasi)) {
    echo "<script>alert('ID Lokasi tidak ditemukan!'); window.location.href = '../home/lokasipresensi.php';</script>";
    exit;
}

// Ambil data lokasi berdasarkan id_lokasi
$sql = "SELECT * FROM lokasi WHERE id_lokasi = '$id_lokasi'";
$result = $conn->query($sql);

// Periksa apakah data ditemukan
if ($result->num_rows == 0) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href = '../home/lokasipresensi.php';</script>";
    exit;
}

$lokasi = $result->fetch_assoc();

// Periksa apakah form telah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_lokasi = $_POST['name_lokasi'];
    $location = $_POST['location'];
    $area_login = $_POST['area_login'];

    // Validasi data
    if ( !empty($name_lokasi) && !empty($location) && !empty($area_login)) {
        // Query untuk memperbarui data
        $sql = "UPDATE lokasi SET 
                name_lokasi = '$name_lokasi', 
                location = '$location', 
                area_login = '$area_login'
                WHERE id_lokasi = '$id_lokasi'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Data lokasi berhasil diperbarui!'); window.location.href = '../home/lokasipresensi.php';</script>";
        } else {
            echo "Error: " . $conn->error;
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
    <title>Edit Lokasi</title>
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
        <h2>Edit Lokasi</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name_lokasi">Nama Lokasi</label>
                <input type="text" id="name_lokasi" name="name_lokasi" value="<?php echo htmlspecialchars($lokasi['name_lokasi']); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Lokasi</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($lokasi['location']); ?>" required>
            </div>
            <div class="form-group">
                <label for="area_login">Area Login</label>
                <input type="number" id="area_login" name="area_login" value="<?php echo htmlspecialchars($lokasi['area_login']); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Simpan Perubahan</button>
            </div>
            <div class="form-group">
                <a href="lokasipresensi.php" class="btn-cancel" style="display: block; text-align: center; padding: 10px; text-decoration: none; color: white;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
