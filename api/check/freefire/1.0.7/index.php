<?php
require_once __DIR__ . '/../../../../includes/database.php';
require_once __DIR__ . '/../../../../includes/crypto.php';

$input = file_get_contents('php://input');

// Nếu không có input, trả về allowed
if (empty($input)) {
    $db = readDB();
    $maintenance = $db['settings']['maintenance_mode'] ?? false;
    echo createResponse([
        'success' => true,
        'allowed' => !$maintenance
    ]);
    exit;
}

$payload = validateRequest($input);
if ($payload && isset($payload['key'])) {
    $keyData = validateKey($payload['key']);
    echo createResponse([
        'success' => true,
        'allowed' => $keyData ? true : false
    ]);
} else {
    echo createResponse(['success' => false, 'allowed' => false]);
}
