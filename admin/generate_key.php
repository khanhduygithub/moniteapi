<?php
require_once '../includes/auth_check.php';
require_once '../includes/database.php';

$message = '';
$generatedKey = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $versionName = $_POST['version_name'] ?? 'OB53-Free';
    $expiryDays = (int)($_POST['expiry_days'] ?? 30);
    
    $random = bin2hex(random_bytes(16));
    $key = 'MONITE-' . strtoupper(substr($random, 0, 4) . '-' . substr($random, 4, 4) . '-' . substr($random, 8, 4) . '-' . substr($random, 12, 4));
    
    $expiresAt = time() + ($expiryDays * 86400);
    
    addKey($key, $expiresAt, $versionName);
    $generatedKey = $key;
    $message = "Key generated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Key - Monite Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0a0a0a; color: #fff; font-family: 'Segoe UI', sans-serif; display: flex; }
        .sidebar { width: 250px; background: #111; border-right: 1px solid #222; padding: 20px; position: fixed; height: 100vh; }
        .sidebar h2 { color: #00ff00; margin-bottom: 30px; }
        .sidebar a { display: block; color: #ccc; text-decoration: none; padding: 12px 15px; border-radius: 8px; margin: 5px 0; }
        .sidebar a:hover, .sidebar a.active { background: #1a1a1a; color: #00ff00; }
        .main { margin-left: 250px; padding: 30px; flex: 1; }
        input, select { width: 100%; padding: 12px; margin: 10px 0; background: #1a1a1a; border: 1px solid #333; color: #fff; border-radius: 6px; }
        button { padding: 12px 25px; background: #00ff00; color: #000; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
        .generated-key { background: #00ff0022; border: 1px solid #00ff00; padding: 20px; border-radius: 12px; margin-top: 20px; text-align: center; }
        .generated-key code { font-size: 24px; color: #00ff00; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>🔧 Monite Admin</h2>
        <a href="index.php">📊 Dashboard</a>
        <a href="keys.php">🔑 Key Manager</a>
        <a href="offsets.php">📋 Offset Manager</a>
        <a href="generate_key.php" class="active">➕ Generate Key</a>
        <a href="logout.php" style="color: #ff4444;">🚪 Logout</a>
    </div>
    
    <div class="main">
        <h1>➕ Generate New Key</h1>
        
        <form method="POST">
            <label>Version Name:</label>
            <input type="text" name="version_name" placeholder="e.g., OB53-Premium" required>
            
            <label>Expiry (days):</label>
            <input type="number" name="expiry_days" value="30" required>
            
            <button type="submit">🔑 Generate Key</button>
        </form>
        
        <?php if ($generatedKey): ?>
        <div class="generated-key">
            <p style="color: #00ff00; margin-bottom: 10px;">✅ Key Generated!</p>
            <code><?= htmlspecialchars($generatedKey) ?></code>
            <p style="color: #888; margin-top: 10px;">Copy this key now - it won't be shown again!</p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
