<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Sertakan file koneksi
require_once '../config/koneksi.php';

// Ambil data dari body request
$data = json_decode(file_get_contents("php://input"), true);

// Validasi input
if (!isset($data['phone_number ']) || !isset($data['password'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "error", "message" => "Harap isi nomor handphone dan password."]);
    exit();
}

$phoneNumber = $data['phone_number '];
$password = $data['password'];

// Gunakan Prepared Statement untuk query
$stmt = $conn->prepare("SELECT * FROM users WHERE phone_number = ? AND password = ?");
$stmt->bind_param("ss", $phoneNumber, $password);
$stmt->execute();
$result = $stmt->get_result();

// Cek hasil query
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    unset($user['password']); // Hapus password sebelum dikirim ke client
    http_response_code(200); // OK
    echo json_encode(["status" => "success", "message" => "Login berhasil", "user" => $user]);
} else {
    http_response_code(401); // Unauthorized
    echo json_encode(["status" => "error", "message" => "Nomor handphone atau password salah."]);
}

$stmt->close();
$conn->close();
?>
