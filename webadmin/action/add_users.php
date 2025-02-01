<?php
// Koneksi ke database
include '../config/koneksi.php';

// Cek apakah form telah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    // Validasi data
    if (!empty($full_name) && !empty($phone_number) && !empty($email)) {
        // Query untuk menambahkan data ke tabel
        $sql = "INSERT INTO users (full_name, phone_number, email) VALUES ('$full_name', '$phone_number', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('User berhasil ditambahkan!'); window.location.href = '../home/datapegawai.php';</script>";
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
    <title>Tambah Users</title>
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
        <h2>Tambah Users</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <button type="submit">Proses</button>
            </div>
            <div class="form-group">
                <a href="datapegawai.php" class="btn-cancel" style="display: block; text-align: center; padding: 10px; text-decoration: none; color: white;">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
