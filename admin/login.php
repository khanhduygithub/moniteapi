<?php
// ==========================================
// MONITE ADMIN - LOGIN KHÔNG CẦN KEY
// ==========================================
session_start();

// Nếu đã login rồi thì vào thẳng dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

// Xử lý login - chỉ cần nhấn nút!
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = 'admin';
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monite Admin - Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0a0a0a; color: #fff; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: #111; border: 1px solid #333; border-radius: 16px; padding: 60px 40px; width: 400px; text-align: center; }
        h1 { color: #00ff00; font-size: 32px; margin-bottom: 10px; }
        p { color: #666; margin-bottom: 30px; }
        button { width: 100%; padding: 16px; background: #00ff00; color: #000; border: none; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer; }
        button:hover { background: #00cc00; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🔧 Monite Admin</h1>
        <p>Quản lý Key & Offsets</p>
        <form method="POST">
            <button type="submit">🔑 Vào Admin</button>
        </form>
    </div>
</body>
</html>
