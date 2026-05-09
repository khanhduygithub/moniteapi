<?php
require_once __DIR__ . '/../includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = '❌ Invalid username or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monite Admin - Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0a0a0a; color: #fff; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: #111; border: 1px solid #333; border-radius: 12px; padding: 40px; width: 380px; }
        h1 { color: #00ff00; text-align: center; margin-bottom: 10px; }
        p { text-align: center; color: #666; margin-bottom: 20px; }
        input { width: 100%; padding: 12px; margin: 10px 0; background: #1a1a1a; border: 1px solid #333; border-radius: 6px; color: #fff; font-size: 14px; }
        button { width: 100%; padding: 12px; background: #00ff00; color: #000; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        button:hover { background: #00cc00; }
        .error { color: #ff4444; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🔧 Monite Admin</h1>
        <p>API Management System</p>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">🔑 Login</button>
        </form>
    </div>
</body>
</html>
