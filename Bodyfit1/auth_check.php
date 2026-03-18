<?php
// auth_check.php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('HTTP/1.1 401 Unauthorized');
    header('Location: login.html');
    exit;
}
?>
