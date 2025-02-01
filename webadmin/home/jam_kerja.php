<?php
// Koneksi ke database
include '../config/koneksi.php';

// Ambil nama file saat ini untuk menentukan menu aktif di sidebar
$current_page = basename($_SERVER['PHP_SELF']);

// Query untuk mengambil data users
$sql = "SELECT full_name, phone_number FROM users";
$result = $conn->query($sql);

// Periksa apakah query berhasil
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        /* Sidebar */
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
        /* Konten */
        .content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
        }
        .btn-export, .btn-add {
            padding: 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-bottom: 10px;
        }
        .btn-export {
            background-color: gray;
        }
        .btn-add {
            background-color: #3498db;
            float: right;
        }
        .btn-add:hover {
            background-color: #2980b9;
        }
        /* Search Box */
        .search-box {
            float: right;
            margin-bottom: 10px;
        }
        .search-box input {
            padding: 8px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        /* Action Buttons */
        .btn-action {
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }
        .btn-blue {
            background-color: #3498db;
        }
        .btn-orange {
            background-color: #e67e22;
        }
        .btn-blue:hover {
            background-color: #2980b9;
        }
        .btn-orange:hover {
            background-color: #d35400;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Control Panel</h3>
        <a href="dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : ''; ?>">Beranda</a>
        <a href="datapegawai.php" class="<?= $current_page == 'datapegawai.php' ? 'active' : ''; ?>">Data Pegawai</a>
        <a href="lokasipresensi.php" class="<?= $current_page == 'lokasipresensi.php' ? 'active' : ''; ?>">Lokasi Presensi</a>
        <a href="jam_kerja.php" class="<?= $current_page == 'jam_kerja.php' ? 'active' : ''; ?>">Jam Kerja Pegawai</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Konten -->
    <div class="content">
        <h2>Kelola Absensi</h2>

        <button class="btn-export">Export</button>
        <a href="action/add_jam_kerja.php" class="btn-add">TAMBAH JENIS ABSENSI</a>

        <div class="search-box">
            <label>Search: <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Cari Pegawai..."></label>
        </div>

        <table id="pegawaiTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Jumlah hari kerja</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                        
                        // Simulasi jumlah hari kerja (Bisa diubah dengan data real dari database absensi)
                        $jumlah_hari_kerja = rand(0, 30); // Contoh acak jumlah hari kerja
                        $status_kerja = ($jumlah_hari_kerja > 0) ? "$jumlah_hari_kerja Hari kerja dibulan ini" : "Tidak memiliki Jadwal Pribadi";
                        
                        echo "<td>$status_kerja</td>";

                        // Tombol Kelola Jam Kerja & Kosongkan Jam Kerja
                        echo "<td>
                            <a href='../action/kelola_jam_kerja.php?phone_number=" . urlencode($row['phone_number']) . "' class='btn-action btn-blue'>Kelola Jam Kerja</a>
                            <a href='../action/kosongkan_jam_kerja.php?phone_number=" . urlencode($row['phone_number']) . "' class='btn-action btn-orange' onclick=\"return confirm('Yakin ingin mengosongkan jam kerja?');\">Kosongkan Jam Kerja</a>
                        </td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data pengguna</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("pegawaiTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Kolom Nama Pegawai
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    tr[i].style.display = (txtValue.toUpperCase().indexOf(filter) > -1) ? "" : "none";
                }
            }
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>
