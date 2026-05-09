<?php
require_once __DIR__ . '/../../../../includes/database.php';
require_once __DIR__ . '/../../../../includes/crypto.php';

// Đọc input
$input = file_get_contents('php://input');
$payload = validateRequest($input);

// Xác thực key trước khi trả offsets
if (!$payload || !isset($payload['key'])) {
    echo createResponse(['success' => false, 'message' => 'Authentication required']);
    exit;
}

$keyData = validateKey($payload['key']);

if (!$keyData) {
    echo createResponse(['success' => false, 'message' => 'Invalid key']);
    exit;
}

// Lấy offsets từ database
$offsets = getOffsets();

$response = [
    'success' => true,
    'offsets' => $offsets,
    'total' => count($offsets)
];

echo createResponse($response);
