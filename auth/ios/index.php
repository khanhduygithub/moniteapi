<?php
require_once __DIR__ . '/../../../includes/database.php';
require_once __DIR__ . '/../../../includes/crypto.php';

// Rate limit
checkRateLimit();

// Đọc input từ client
$input = file_get_contents('php://input');
$payload = validateRequest($input);

// Kiểm tra payload hợp lệ
if (!$payload || !isset($payload['key'])) {
    echo createResponse(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Validate key
$keyData = validateKey($payload['key']);

if ($keyData) {
    // Key hợp lệ - trả về thông tin
    $response = [
        'success' => true,
        'key' => $keyData['key'],
        'version_name' => $keyData['version_name'] ?? 'OB53',
        'version' => $keyData['created_at'] ?? time(),
        'expires_at' => $keyData['expires_at'] ?? time() + 86400 * 30,
        'message' => 'Login successful'
    ];
} else {
    // Key không hợp lệ hoặc hết hạn
    $response = [
        'success' => false,
        'message' => 'Invalid or expired key'
    ];
}

echo createResponse($response);
