<?php
header('Content-Type: application/json');
require '../config/koneksi.php'; // Koneksi ke database

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['phone_number'])) {
    $phoneNumber = $input['phone_number'];

    $query = "SELECT full_name, jabatan FROM users WHERE phone_number = '$phoneNumber'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'status' => 'success',
            'data' => [
                'full_name' => $row['full_name'],
                'jabatan' => $row['jabatan']
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
$conn->close();
?>
