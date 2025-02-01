<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);
    $periode = isset($_POST['periode']) ? (int)$_POST['periode'] : 1; // Default ke 1 bulan jika tidak diisi

    $errors = [];

    if (empty($phone_number) || empty($date) || empty($start_time) || empty($end_time)) {
        $errors[] = "Semua field harus diisi!";
    }

    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => implode(", ", $errors)]);
        exit;
    }

    $success = 0;
    $failed = 0;

    // Loop untuk menambahkan data ke beberapa bulan ke depan
    for ($i = 0; $i < $periode; $i++) {
        $new_date = date('Y-m-d', strtotime("+$i month", strtotime($date)));

        // Cek apakah jam kerja sudah ada di database
        $checkQuery = "SELECT * FROM jam_kerja WHERE staff = '$phone_number' AND date = '$new_date'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) == 0) {
            // Insert data baru
            $query = "INSERT INTO jam_kerja (staff, date, start_hour, finish_hour) VALUES ('$phone_number', '$new_date', '$start_time', '$end_time')";
        } else {
            // Update data yang sudah ada
            $query = "UPDATE jam_kerja SET start_hour = '$start_time', finish_hour = '$end_time' WHERE staff = '$phone_number' AND date = '$new_date'";
        }

        if (mysqli_query($conn, $query)) {
            $success++;
        } else {
            $failed++;
        }
    }

    if ($success > 0) {
        echo json_encode(["status" => "success", "message" => "$success data berhasil disimpan"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan data"]);
    }
}
?>
