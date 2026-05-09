<?php
// ============================================
// MONITE API - CONFIGURATION FILE
// ============================================

session_start();

// ═══════════════════════════════════════════
// ADMIN CREDENTIALS
// ═══════════════════════════════════════════
define('ADMIN_USERNAME', 'admin');
// MẬT KHẨU MẶC ĐỊNH: admin123
// ĐỔI MẬT KHẨU: chạy file set_password.php (tạo riêng)
define('ADMIN_PASSWORD_HASH', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

// ═══════════════════════════════════════════
// AES ENCRYPTION KEY (PHẢI KHỚP VỚI load.mm)
// ═══════════════════════════════════════════
// Key bytes trong load.mm:
// 0xA1,0xB2,0xC3,0xD4,0xE5,0xF6,0x07,0x18,
// 0x29,0x3A,0x4B,0x5C,0x6D,0x7E,0x8F,0x90,
// 0x12,0x23,0x34,0x45,0x56,0x67,0x78,0x89,
// 0x9A,0xAB,0xBC,0xCD,0xDE,0xEF,0xF0,0x01
define('AES_KEY', hex2bin('A1B2C3D4E5F60718293A4B5C6D7E8F9012233445566778899AABBCCDDEEFF001'));

// ═══════════════════════════════════════════
// DATABASE FILE PATH
// ═══════════════════════════════════════════
define('DB_FILE', __DIR__ . '/../api/database.json');

// ═══════════════════════════════════════════
// TIMEZONE
// ═══════════════════════════════════════════
date_default_timezone_set('Asia/Ho_Chi_Minh');

// ═══════════════════════════════════════════
// RATE LIMITING
// ═══════════════════════════════════════════
define('MAX_REQUESTS', 10);
define('RATE_WINDOW', 60);

// ═══════════════════════════════════════════
// API VERSION
// ═══════════════════════════════════════════
define('API_VERSION', '1.0.7-FFProduct');

// Set JSON header cho API endpoints
$isApiRequest = strpos($_SERVER['REQUEST_URI'], '/api/') !== false;
if ($isApiRequest) {
    header('Content-Type: application/json');
}
