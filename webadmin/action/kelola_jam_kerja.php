<?php
// Koneksi ke database
include '../config/koneksi.php';

// Ambil nomor telepon dari URL
$phone_number = isset($_GET['phone_number']) ? mysqli_real_escape_string($conn, $_GET['phone_number']) : '';

// Ambil data pengguna berdasarkan nomor telepon
$userQuery = mysqli_query($conn, "SELECT full_name FROM users WHERE phone_number = '$phone_number'");
$user = mysqli_fetch_assoc($userQuery);

if (!$user) {
    die("Data pengguna tidak ditemukan.");
}

// Ambil bulan & tahun dari GET atau default ke bulan & tahun sekarang
$currentYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
$currentMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$tanggalTeks = date('F', mktime(0, 0, 0, $currentMonth, 1));

// Ambil data jam kerja dari tabel `jam_kerja`
$queryJamKerja = "SELECT * FROM jam_kerja WHERE staff = '$phone_number' AND MONTH(date) = '$currentMonth' AND YEAR(date) = '$currentYear'";
$dataJamKerja = mysqli_query($conn, $queryJamKerja);

// Simpan data dalam array untuk kemudahan akses
$jamKerjaArray = [];
while ($row = mysqli_fetch_assoc($dataJamKerja)) {
    $jamKerjaArray[$row['date']] = $row;
}

// Hitung jumlah hari dalam bulan ini
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
$firstDay = date('N', strtotime("$currentYear-$currentMonth-01"));

// Hitung bulan sebelumnya dan berikutnya
$prevMonth = date('m', strtotime("$currentYear-$currentMonth-01 -1 month"));
$prevYear = date('Y', strtotime("$currentYear-$currentMonth-01 -1 month"));
$nextMonth = date('m', strtotime("$currentYear-$currentMonth-01 +1 month"));
$nextYear = date('Y', strtotime("$currentYear-$currentMonth-01 +1 month"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jam Kerja</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
        .btn-danger { background-color: red; color: white; border: none; cursor: pointer; font-size: 12px; }
        .btn-action { padding: 10px; text-decoration: none; color: white; border-radius: 5px; border: none; cursor: pointer; margin-bottom: 10px; }
        .btn-warning { background-color: red; color: white; border: none; cursor: pointer; font-size: 12px; }
        .btn-success { background-color: green; color: white; border: none; cursor: pointer; font-size: 12px; }
        .btn-secondary { background-color: gray; }
    </style>
</head>
<body>

<h2>Jam Kerja <?= htmlspecialchars($user['full_name']); ?> (Bulan <?= $tanggalTeks; ?> <?= $currentYear; ?>)</h2>

<!-- Tombol Kembali ke `jam_kerja.php` -->
<a href="../home/jam_kerja.php" class="btn-action btn-secondary">⬅ Kembali</a>
<!-- Navigasi bulan -->
    <a href="kelola_jam_kerja.php?phone_number=<?= $phone_number; ?>&year=<?= $prevYear; ?>&month=<?= $prevMonth; ?>" class="btn-action btn-warning">Bulan Sebelumnya</a>
    <a href="kelola_jam_kerja.php?phone_number=<?= $phone_number; ?>&year=<?= $nextYear; ?>&month=<?= $nextMonth; ?>" class="btn-action btn-success">Bulan Berikutnya</a>

<!-- Kalender -->
<table>
    <thead>
        <tr>
            <th>Senin</th><th>Selasa</th><th>Rabu</th><th>Kamis</th><th>Jumat</th><th>Sabtu</th><th>Minggu</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dayCount = 1;
        for ($i = 1; $i <= 6; $i++) {
            echo "<tr>";
            for ($j = 1; $j <= 7; $j++) {
                if (($i == 1 && $j < $firstDay) || $dayCount > $daysInMonth) {
                    echo "<td>&nbsp;</td>";
                } else {
                    $currentDate = "$currentYear-$currentMonth-" . str_pad($dayCount, 2, '0', STR_PAD_LEFT);
                    
                    // Ambil data jam kerja jika tersedia
                    $jamKerja = isset($jamKerjaArray[$currentDate]) ? $jamKerjaArray[$currentDate] : null;
                    $startHour = $jamKerja ? $jamKerja['start_hour'] : '---';
                    $finishHour = $jamKerja ? $jamKerja['finish_hour'] : '---';

                    echo "<td>
                        <button onclick='editJamKerja(\"$currentDate\")'>$dayCount</button><br>
                        $startHour - $finishHour
                        ". ($jamKerja ? "<button class='btn-danger' onclick='hapusJamKerja(\"$jamKerja[id_jam_kerja]\", \"$currentDate\")'>X</button>" : "") ."
                    </td>";
                    $dayCount++;
                }
            }
            echo "</tr>";
            if ($dayCount > $daysInMonth) break;
        }
        ?>
    </tbody>
</table>

<script>
function editJamKerja(date) {
    Swal.fire({
        title: 'Ubah Jam kerja untuk Tanggal: ' + date,
        html: `
            <label>Jam Masuk:</label>
            <input type="time" id="start_time" class="swal2-input">
            <label>Jam Selesai:</label>
            <input type="time" id="end_time" class="swal2-input">
            <label>Periode:</label>
            <select id="periode" class="swal2-input">
                <option value="1">1 Bulan</option>
                <option value="2">2 Bulan</option>
                <option value="3">3 Bulan</option>
                <option value="6">6 Bulan</option>
                <option value="12">12 Bulan</option>
            </select>
        `,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        preConfirm: () => {
            return {
                start_time: document.getElementById('start_time').value,
                end_time: document.getElementById('end_time').value,
                periode: document.getElementById('periode').value
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let start_time = result.value.start_time;
            let end_time = result.value.end_time;
            let periode = result.value.periode;

            if (!start_time || !end_time || !periode) {
                Swal.fire("Gagal!", "Semua field harus diisi!", "error");
                return;
            }

            // Kirim data ke backend dengan AJAX
            $.ajax({
                url: '../action/simpan_jam_kerja.php',
                type: 'POST',
                data: {
                    date: date,
                    start_time: start_time,
                    end_time: end_time,
                    periode: periode,
                    phone_number: "<?= $phone_number ?>"
                },
                success: function(response) {
                    console.log(response); // Debugging - lihat response dari server
                    let res = JSON.parse(response);

                    if (res.status === "success") {
                        Swal.fire("Berhasil!", res.message, "success").then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Gagal!", res.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    Swal.fire("Gagal!", "Terjadi kesalahan saat menyimpan data.", "error");
                }
            });
        }
    });
}
</script>


</body>
</html>
