<?php
// ============================================
// MONITE API - DATABASE FUNCTIONS
// ============================================
require_once __DIR__ . '/config.php';

/**
 * Đọc database từ file JSON
 */
function readDB() {
    if (!file_exists(DB_FILE)) {
        // Tạo database mặc định nếu chưa có
        $initial = [
            'keys' => [],
            'offsets' => [
                "get_main" => "0x4A8478C",
                "get_transform" => "0x854060C",
                "get_transformNode" => "0x5C52CFC",
                "WorldToViewpoint" => "0x84E6AC8",
                "get_position" => "0x8552BAC",
                "Team" => "0x4A38D90",
                "Local" => "0x28FC854",
                "get_HP" => "0x58691B8",
                "get_maxHP" => "0x4A8489C",
                "get_IsDieing" => "0x4A02EA8",
                "get_IsVisible" => "0x4A20AF4",
                "GetLocalPlayer" => "0x4C5A64C",
                "CurrentMatch" => "0x4E355B0",
                "Camera_main" => "0x84E7148",
                "GetRotation" => "0x5081084",
                "get_isLocalTeam" => "0x55A0560",
                "get_IsSighting" => "0x4A0FF18",
                "get_IsFiring" => "0x56D1580",
                "WorldToScreenPoint" => "0x84E6AC8",
                "GetHeadPositions" => "0x4AA1A28",
                "Component_GetTransform" => "0x854060C",
                "GetForward" => "0x85534CC",
                "Player_GetHeadCollider" => "0x4A1A9D4",
                "Transform_GetPosition" => "0x8552C10",
                "GetAnimator" => "0x0",
                "Physics_Raycast" => "0x5580870",
                "set_aim" => "0x4A1C91C",
                "HipPosition" => "0x4AA1BD8",
                "LeftShoulderPosition" => "0x0",
                "RightShoulderPosition" => "0x0",
                "LeftAnklePosition" => "0x4AA2028",
                "RightAnklePosition" => "0x4AA2134",
                "LeftToePosition" => "0x4AA2240",
                "RightToePosition" => "0x4AA234C",
                "LeftHandPosition" => "0x4A1B9B4",
                "RightHandPosition" => "0x4A1BAB8",
                "RightForeArmPosition" => "0x4A1BCC0",
                "LeftForeArmPosition" => "0x4A1BBBC",
                "CameraMain" => "0x84E7148",
                "IsClientBot" => "0x0",
                "IsAvatarInit" => "0x0",
                "MatchPlayers" => "0x4C869DC",
                "get_NickName" => "0x4A16D38",
                "get_BannerID" => "0x0",
                "FindBone" => "0x470F5D8",
                "GetTeamID" => "0x51C57E4",
                "IsDead" => "0x2FECBA0",
                "NoFog" => "0x850363C"
            ],
            'settings' => [
                'site_title' => 'Monite API',
                'maintenance_mode' => false
            ]
        ];
        writeDB($initial);
        return $initial;
    }
    $content = file_get_contents(DB_FILE);
    return json_decode($content, true) ?: ['keys' => [], 'offsets' => []];
}

/**
 * Ghi database vào file JSON
 */
function writeDB($data) {
    file_put_contents(
        DB_FILE, 
        json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
    );
}

/**
 * Kiểm tra key hợp lệ
 */
function validateKey($key) {
    $db = readDB();
    foreach ($db['keys'] as $k) {
        if ($k['key'] === $key && $k['active'] && $k['expires_at'] > time()) {
            // Ghi log usage
            logKeyUsage($key);
            return $k;
        }
    }
    return null;
}

/**
 * Lấy tất cả offsets
 */
function getOffsets() {
    $db = readDB();
    return $db['offsets'] ?? [];
}

/**
 * Lưu offsets
 */
function saveOffsets($offsets) {
    $db = readDB();
    $db['offsets'] = $offsets;
    writeDB($db);
    return true;
}

/**
 * Thêm key mới
 */
function addKey($key, $expiresAt, $versionName, $createdBy = 'admin') {
    $db = readDB();
    $db['keys'][] = [
        'key' => $key,
        'created_at' => time(),
        'expires_at' => $expiresAt,
        'version_name' => $versionName,
        'active' => true,
        'created_by' => $createdBy,
        'last_used' => null,
        'usage_count' => 0
    ];
    writeDB($db);
    return $key;
}

/**
 * Xóa key
 */
function deleteKey($key) {
    $db = readDB();
    foreach ($db['keys'] as $i => $k) {
        if ($k['key'] === $key) {
            unset($db['keys'][$i]);
            $db['keys'] = array_values($db['keys']);
            writeDB($db);
            return true;
        }
    }
    return false;
}

/**
 * Bật/tắt key
 */
function toggleKeyStatus($key) {
    $db = readDB();
    foreach ($db['keys'] as $i => $k) {
        if ($k['key'] === $key) {
            $db['keys'][$i]['active'] = !$db['keys'][$i]['active'];
            writeDB($db);
            return true;
        }
    }
    return false;
}

/**
 * Cập nhật thời gian hết hạn
 */
function updateKeyExpiry($key, $newExpiry) {
    $db = readDB();
    foreach ($db['keys'] as $i => $k) {
        if ($k['key'] === $key) {
            $db['keys'][$i]['expires_at'] = $newExpiry;
            writeDB($db);
            return true;
        }
    }
    return false;
}

/**
 * Ghi log sử dụng key
 */
function logKeyUsage($key) {
    $db = readDB();
    foreach ($db['keys'] as $i => $k) {
        if ($k['key'] === $key) {
            $db['keys'][$i]['last_used'] = time();
            $db['keys'][$i]['usage_count'] = ($db['keys'][$i]['usage_count'] ?? 0) + 1;
            writeDB($db);
            return true;
        }
    }
    return false;
}
