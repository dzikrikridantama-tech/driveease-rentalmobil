<?php
session_start();

// 1. Hapus semua data session yang tersimpan
$_SESSION = array();

// 2. Hancurkan session di server
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// 3. Alihkan customer ke halaman utama (index.php) dengan parameter status logout
header("Location: index.php?status=logout_sukses");
exit;