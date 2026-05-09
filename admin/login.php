<?php
// ==========================================
// MONITE ADMIN - LOGIN
// ==========================================
session_start();

// Load config
require_once __DIR__ . '/../includes/config.php';

$error = '';

// Nếu đã login rồi thì chuyển thẳng vào dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

// Xử lý login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Kiểm tra
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        // Login thành công
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_login_time'] = time();
        header('Location: index.php');
        exit;
    } else {
        $error = '❌ Sai tên đăng nhập hoặc mật khẩu!';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monite Admin - Đăng Nhập</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            background: #0a0a0a; 
            color: #fff; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh;
            min-height: 100vh;
        }
        .login-box { 
            background: #111; 
            border: 1px solid #333; 
            border-radius: 16px; 
            padding: 40px; 
            width: 400px;
            max-width: 90%;
        }
        h1 { 
            color: #00ff00; 
            text-align: center; 
            margin-bottom: 5px;
            font-size: 28px;
        }
        .subtitle { 
            text-align: center; 
            color: #666; 
            margin-bottom: 30px;
            font-size: 14px;
        }
        label {
            display: block;
            color: #888;
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: bold;
        }
        input { 
            width: 100%; 
            padding: 14px 16px; 
            margin-bottom: 15px;
            background: #1a1a1a; 
            border: 1px solid #333; 
            border-radius: 8px; 
            color: #fff; 
            font-size: 15px;
            transition: border 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #00ff00;
        }
        button { 
            width: 100%; 
            padding: 14px; 
            background: #00ff00; 
            color: #000; 
            border: none; 
            border-radius: 8px; 
            font-size: 16px; 
            font-weight: bold; 
            cursor: pointer; 
            margin-top: 5px;
            transition: background 0.3s;
        }
        button:hover { 
            background: #00cc00; 
        }
        .error { 
            color: #ff4444; 
            text-align: center; 
            margin-bottom: 20px;
            background: #ff444411;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ff444444;
        }
        .info {
            text-align: center;
            color: #666;
            margin-top: 20px;
            font-size: 12px;
        }
        .info code {
            background: #1a1a1a;
            padding: 3px 8px;
            border-radius: 4px;
            color: #00ff00;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🔧 Monite Admin</h1>
        <p class="subtitle">Hệ Thống Quản Lý API</p>
        
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" autocomplete="off">
            <label>Tên đăng nhập</label>
            <input type="text" name="username" placeholder="Nhập username" required autofocus>
            
            <label>Mật khẩu</label>
            <input type="password" name="password" placeholder="Nhập mật khẩu" required>
            
            <button type="submit">🔑 Đăng Nhập</button>
        </form>
        
        <div class="info">
            Mặc định: <code>admin</code> / <code>admin123</code>
        </div>
    </div>
</body>
</html>
