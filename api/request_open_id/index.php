<?php
require_once __DIR__ . '/../../includes/crypto.php';

// Tạo open_id mới
$openId = 'OPEN-' . strtoupper(bin2hex(random_bytes(12)));

echo createResponse([
    'open_id' => $openId,
    'url' => 'https://yourdomain.com/register-udid?open_id=' . $openId
]);
