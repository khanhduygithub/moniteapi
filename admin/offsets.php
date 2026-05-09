<?php
require_once '../includes/auth_check.php';
require_once '../includes/database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['offsets'])) {
    $offsets = [];
    foreach ($_POST['offsets'] as $name => $value) {
        if (!empty($name) && !empty($value)) {
            $offsets[strip_tags($name)] = strip_tags($value);
        }
    }
    saveOffsets($offsets);
    $message = 'Offsets saved successfully!';
}

$db = readDB();
$offsets = getOffsets();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Offset Manager - Monite Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0a0a0a; color: #fff; font-family: 'Segoe UI', sans-serif; display: flex; }
        .sidebar { width: 250px; background: #111; border-right: 1px solid #222; padding: 20px; position: fixed; height: 100vh; }
        .sidebar h2 { color: #00ff00; margin-bottom: 30px; }
        .sidebar a { display: block; color: #ccc; text-decoration: none; padding: 12px 15px; border-radius: 8px; margin: 5px 0; }
        .sidebar a:hover, .sidebar a.active { background: #1a1a1a; color: #00ff00; }
        .main { margin-left: 250px; padding: 30px; flex: 1; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #222; padding: 10px; }
        th { background: #111; color: #00ff00; }
        input { width: 100%; padding: 8px; background: #1a1a1a; border: 1px solid #333; color: #0f0; border-radius: 4px; }
        button { padding: 12px 25px; background: #00ff00; color: #000; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 20px; }
        .message { background: #00ff0022; color: #00ff00; padding: 10px; border-radius: 8px; margin-bottom: 20px; }
        .add-row { margin-top: 20px; }
        .add-row input { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>🔧 Monite Admin</h2>
        <a href="index.php">📊 Dashboard</a>
        <a href="keys.php">🔑 Key Manager</a>
        <a href="offsets.php" class="active">📋 Offset Manager</a>
        <a href="logout.php" style="color: #ff4444;">🚪 Logout</a>
    </div>
    
    <div class="main">
        <h1>📋 Offset Manager</h1>
        
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <table id="offsetTable">
                <tr><th>Offset Name</th><th>Value</th></tr>
                <?php foreach ($offsets as $name => $value): ?>
                <tr>
                    <td><input type="text" name="offsets[<?= htmlspecialchars($name) ?>]" value="<?= htmlspecialchars($name) ?>"></td>
                    <td><input type="text" name="offsets[<?= htmlspecialchars($name) ?>]" value="<?= htmlspecialchars($value) ?>"></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <button type="submit">💾 Save All Offsets</button>
        </form>
    </div>
</body>
</html>
