<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/crypto.php';

$input = file_get_contents('php://input');
$payload = validateRequest($input);

if ($payload && isset($payload['open_id'])) {
    // Trong thực tế, check open_id trong database
    // Hiện tại trả về status "exists" với UDID mặc định
    echo createResponse([
        'status' => 'exists',
        'udid' => 'DEVICE-' . strtoupper(substr(md5($payload['open_id']), 0, 16))
    ]);
} else {
    echo createResponse([
        'status' => 'new',
        'url' => 'https://yourdomain.com/register-udid'
    ]);
}
