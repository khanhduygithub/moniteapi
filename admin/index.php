<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/database.php';

$db = readDB();
$totalKeys = count($db['keys']);
$activeKeys = 0;
$totalUsage = 0;

foreach ($db['keys'] as $k) {
    if ($k['active'] && $k['expires_at'] > time()) $activeKeys++;
    $totalUsage += $k['usage_count'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Monite Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0a0a0a; color: #fff; font-family: 'Segoe UI', sans-serif; display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: #111; border-right: 1px solid #222; padding: 20px; position: fixed; height: 100vh; }
        .sidebar h2 { color: #00ff00; margin-bottom: 30px; font-size: 18px; }
        .sidebar a { display: block; color: #ccc; text-decoration: none; padding: 12px 15px; border-radius: 8px; margin: 5px 0; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #1a1a1a; color: #00ff00; }
        .main { margin-left: 250px; padding: 30px; flex: 1; }
        h1 { margin-bottom: 5px; }
        .subtitle { color: #666; margin-bottom: 30px; }
        .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .card { background: #111; border: 1px solid #222; border-radius: 12px; padding: 25px; text-align: center; }
        .card h3 { color: #888; font-size: 14px; text-transform: uppercase; margin-bottom: 10px; }
        .card .num { font-size: 36px; font-weight: bold; }
        .card .num.green { color: #00ff00; }
        .card .num.blue { color: #4488ff; }
        .card .num.orange { color: #ffaa00; }
        .actions { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
        .btn { padding: 15px; border-radius: 8px; text-align: center; text-decoration: none; font-weight: bold; }
        .btn-green { background: #00ff00; color: #000; }
        .btn-blue { background: #4488ff; color: #fff; }
        .btn-orange { background: #ffaa00; color: #000; }
        .btn:hover { opacity: 0.8; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>🔧 Monite Admin</h2>
        <a href="index.php" class="active">📊 Dashboard</a>
        <a href="keys.php">🔑 Key Manager</a>
        <a href="offsets.php">📋 Offset Manager</a>
        <a href="generate_key.php">➕ Generate Key</a>
        <a href="logout.php" style="color: #ff4444; margin-top: 50px;">🚪 Logout</a>
    </div>
    
    <div class="main">
        <h1>📊 Dashboard</h1>
        <p class="subtitle">Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?> | API v<?= API_VERSION ?></p>
        
        <div class="cards">
            <div class="card">
                <h3>Total Keys</h3>
                <div class="num blue"><?= $totalKeys ?></div>
            </div>
            <div class="card">
                <h3>Active Keys</h3>
                <div class="num green"><?= $activeKeys ?></div>
            </div>
            <div class="card">
                <h3>Total Usage</h3>
                <div class="num orange"><?= $totalUsage ?></div>
            </div>
        </div>
        
        <div class="actions">
            <a href="generate_key.php" class="btn btn-green">🔑 Generate New Key</a>
            <a href="keys.php" class="btn btn-blue">🔑 Manage Keys</a>
            <a href="offsets.php" class="btn btn-orange">📋 Edit Offsets</a>
        </div>
    </div>
</body>
</html>
