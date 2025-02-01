<?php
// Koneksi ke database
include '../config/koneksi.php';

// Ambil phone_number dari URL
$phone_number = $_GET['phone_number'] ?? '';

// Periksa apakah phone_number ada
if (empty($phone_number)) {
    echo "<script>alert('Phone Number tidak ditemukan!'); window.location.href = '../home/datapegawai.php';</script>";
    exit;
}

// Ambil data user berdasarkan phone_number
$sql = "SELECT * FROM users WHERE phone_number = '$phone_number'";
$result = $conn->query($sql);

// Periksa apakah data ditemukan
if ($result->num_rows == 0) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href = '../home/datapegawai.php';</script>";
    exit;
}

$user = $result->fetch_assoc();

// Periksa apakah form telah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $new_phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    // Validasi data
    if (!empty($full_name) && !empty($new_phone_number) && !empty($email)) {
        // Query untuk memperbarui data
        $sql = "UPDATE users SET full_name = '$full_name', phone_number = '$new_phone_number', email = '$email' WHERE phone_number = '$phone_number'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Data berhasil diperbarui!'); window.location.href = '../home/datapegawai.php';</script>";
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
    <title>Edit Users</title>
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
        <h2>Edit Users</h2>
        <form action="../action/edit_users.php" method="POST">
            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
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
