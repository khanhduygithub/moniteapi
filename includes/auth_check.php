<?php
// ============================================
// MONITE API - ADMIN AUTH CHECK
// ============================================
session_start();

// Nếu chưa đăng nhập, chuyển về trang login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
