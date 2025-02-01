<?php
// Koneksi ke database
include '../config/koneksi.php';

// Query untuk mendapatkan data
$sql = "SELECT full_name, phone_number, email FROM users"; // Query hanya dengan phone_number
$result = $conn->query($sql);

// Periksa apakah query berhasil
if (!$result) {
    die("Query gagal: " . $conn->error);
}

// Tentukan menu aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            position: fixed;
            height: 100%;
            padding-top: 20px;
        }
        .sidebar h3 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 5px 0;
        }
        .sidebar a.active {
            background-color: #3498db;
            font-weight: bold;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .edit-btn {
            color: green;
            text-decoration: none;
        }
        .delete-btn {
            color: red;
            text-decoration: none;
        }
        .btn-add {
            display: inline-block;
            text-decoration: none;
            background: green;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn-add:hover {
            background: darkgreen;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Control Panel</h3>
        <a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Beranda</a>
        <a href="datapegawai.php" class="<?php echo $current_page == 'datapegawai.php' ? 'active' : ''; ?>">Data Pegawai</a>
        <a href="lokasipresensi.php" class="<?php echo $current_page == 'lokasipresensi.php' ? 'active' : ''; ?>">Lokasi Presensi</a>
        <a href="jam_kerja.php" class="<?php echo $current_page == 'jam_kerja.php' ? 'active' : ''; ?>">Jam Kerja Pegawai</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Konten -->
    <div class="content">
        <h2>Data Pegawai</h2>
        <a href="../action/add_users.php" class="btn-add">Tambah Pegawai</a>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Periksa apakah ada data
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        // Escaping untuk mencegah XSS
                        $full_name = htmlspecialchars($row['full_name']);
                        $phone_number = htmlspecialchars($row['phone_number']);
                        $email = htmlspecialchars($row['email']);
                        
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $full_name . "</td>";
                        echo "<td>" . $phone_number . "</td>";
                        echo "<td>" . $email . "</td>";
                        echo "<td>";
                        echo "<a class='edit-btn' href='../action/edit_users.php?phone_number=" . urlencode($phone_number) . "'>Edit</a> | ";
                        echo "<a class='delete-btn' href='../action/hapus.php?phone_number=" . urlencode($phone_number) . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
