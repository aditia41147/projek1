<?php
// Contoh API response (dapat dikembangkan lebih lanjut)
function response($status, $message, $data = [])
{
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit();
}
?>
