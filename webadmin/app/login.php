<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Memasukkan file koneksi
require '../config/koneksi.php';

// Nonaktifkan error output untuk memastikan hanya JSON yang dikembalikan
ini_set('display_errors', 0);
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input JSON dari request
    $input = json_decode(file_get_contents("php://input"), true);

    // Validasi input
    if (isset($input['phone_number']) && isset($input['password'])) {
        $phone_number = $conn->real_escape_string($input['phone_number']);
        $password = md5($conn->real_escape_string($input['password'])); // Hash password dengan MD5

        // Query untuk cek login
        $query = "SELECT full_name, email FROM users WHERE phone_number = '$phone_number' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo json_encode([
                "status" => "success",
                "message" => "Login berhasil",
                "user" => $user
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Nomor telepon atau password salah"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Input tidak valid"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Metode request tidak valid"
    ]);
}

$conn->close();
?>
