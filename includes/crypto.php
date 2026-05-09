<?php
// ============================================
// MONITE API - ENCRYPTION FUNCTIONS
// ============================================
require_once __DIR__ . '/config.php';

/**
 * Mã hóa dữ liệu với AES-256-CBC
 */
function encryptData($plaintext) {
    $key = AES_KEY;
    $iv = random_bytes(16); // IV ngẫu nhiên 16 bytes
    $encrypted = openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    // Ghép IV + encrypted rồi base64
    return base64_encode($iv . $encrypted);
}

/**
 * Giải mã dữ liệu
 */
function decryptData($ciphertext_base64) {
    $key = AES_KEY;
    $data = base64_decode($ciphertext_base64);
    if (strlen($data) < 16) return null;
    // Tách IV (16 bytes đầu) và ciphertext
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);
    $result = openssl_decrypt($ciphertext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return $result;
}

/**
 * Validate request từ client (giải mã + parse JSON)
 */
function validateRequest($input_base64) {
    try {
        $decrypted = decryptData($input_base64);
        if (!$decrypted) return null;
        return json_decode($decrypted, true);
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Tạo response mã hóa
 */
function createResponse($data) {
    $json = json_encode($data);
    return encryptData($json);
}

/**
 * Rate limiting - chống spam
 */
function checkRateLimit() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $key = "rate_" . md5($ip);
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 0, 'start' => time()];
    }
    
    // Reset sau mỗi phút
    if (time() - $_SESSION[$key]['start'] > RATE_WINDOW) {
        $_SESSION[$key] = ['count' => 0, 'start' => time()];
    }
    
    $_SESSION[$key]['count']++;
    
    if ($_SESSION[$key]['count'] > MAX_REQUESTS) {
        http_response_code(429);
        echo json_encode(['success' => false, 'message' => 'Too many requests. Try again later.']);
        exit;
    }
}
