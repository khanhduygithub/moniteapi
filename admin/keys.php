<?php
require_once '../includes/auth_check.php';
require_once '../includes/database.php';

$db = readDB();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'delete':
                if (deleteKey($_POST['key'])) $message = 'Key deleted!';
                break;
            case 'toggle':
                if (toggleKeyStatus($_POST['key'])) $message = 'Status toggled!';
                break;
            case 'extend':
                $newExpiry = strtotime($_POST['new_expiry']);
                if (updateKeyExpiry($_POST['key'], $newExpiry)) $message = 'Expiry updated!';
                break;
        }
    }
}

$db = readDB(); // Refresh
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Key Manager - Monite Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0a0a0a; color: #fff; font-family: 'Segoe UI', sans-serif; display: flex; }
        .sidebar { width: 250px; background: #111; border-right: 1px solid #222; padding: 20px; position: fixed; height: 100vh; }
        .sidebar h2 { color: #00ff00; margin-bottom: 30px; }
        .sidebar a { display: block; color: #ccc; text-decoration: none; padding: 12px 15px; border-radius: 8px; margin: 5px 0; }
        .sidebar a:hover, .sidebar a.active { background: #1a1a1a; color: #00ff00; }
        .main { margin-left: 250px; padding: 30px; flex: 1; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #222; padding: 10px; text-align: left; }
        th { background: #111; color: #00ff00; }
        button { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; margin: 2px; }
        .btn-green { background: #00ff00; color: #000; }
        .btn-red { background: #ff4444; color: #fff; }
        .btn-blue { background: #4488ff; color: #fff; }
        .message { background: #00ff0022; color: #00ff00; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>🔧 Monite Admin</h2>
        <a href="index.php">📊 Dashboard</a>
        <a href="keys.php" class="active">🔑 Key Manager</a>
        <a href="offsets.php">📋 Offset Manager</a>
        <a href="generate_key.php">➕ Generate Key</a>
        <a href="logout.php" style="color: #ff4444;">🚪 Logout</a>
    </div>
    
    <div class="main">
        <h1>🔑 Key Manager</h1>
        
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <table>
            <tr>
                <th>Key</th><th>Version</th><th>Created</th><th>Expires</th>
                <th>Status</th><th>Usage</th><th>Last Used</th><th>Actions</th>
            </tr>
            <?php foreach (array_reverse($db['keys']) as $k): ?>
            <tr>
                <td><code><?= htmlspecialchars($k['key']) ?></code></td>
                <td><?= htmlspecialchars($k['version_name']) ?></td>
                <td><?= date('Y-m-d', $k['created_at']) ?></td>
                <td><?= date('Y-m-d H:i', $k['expires_at']) ?></td>
                <td><?= ($k['active'] && $k['expires_at'] > time()) ? '🟢 Active' : '🔴 Expired' ?></td>
                <td><?= $k['usage_count'] ?></td>
                <td><?= $k['last_used'] ? date('Y-m-d H:i', $k['last_used']) : 'Never' ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="key" value="<?= htmlspecialchars($k['key']) ?>">
                        <input type="hidden" name="action" value="toggle">
                        <button type="submit" class="btn-blue">Toggle</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="key" value="<?= htmlspecialchars($k['key']) ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="btn-red" onclick="return confirm('Delete this key?')">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
