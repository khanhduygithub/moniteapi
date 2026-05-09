<?php
session_start();
header('Content-Type: application/json');

// Đọc input JSON
$input = json_decode(file_get_contents('php://input'), true);
$oldPassword = $input['old_password'] ?? '';
$newPassword = $input['new_password'] ?? '';

// Load config
require_once __DIR__ . '/../includes/config.php';

// Kiểm tra mật khẩu cũ
if (!password_verify($oldPassword, ADMIN_PASSWORD_HASH)) {
    echo json_encode(['success' => false, 'message' => 'Mật khẩu hiện tại không đúng!']);
    exit;
}

// Tạo hash mới
$newHash = password_hash($newPassword, PASSWORD_BCRYPT);

// Đọc file config.php
$configFile = __DIR__ . '/../includes/config.php';
$configContent = file_get_contents($configFile);

// Thay thế hash cũ bằng hash mới
$pattern = "/define\('ADMIN_PASSWORD_HASH',\s*'[^']*'\);/";
$replacement = "define('ADMIN_PASSWORD_HASH', '" . $newHash . "');";
$newConfigContent = preg_replace($pattern, $replacement, $configContent);

// Ghi lại file config
if (file_put_contents($configFile, $newConfigContent)) {
    echo json_encode(['success' => true, 'message' => 'Mật khẩu đã được đổi thành công!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Không thể ghi file config! Kiểm tra quyền CHMOD.']);
}
