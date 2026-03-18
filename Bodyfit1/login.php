<?php
// login.php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = getUserByUsername($conn, $username);
    
    if ($user && password_verify($password, $user['senha'])) {
        // Autenticação bem-sucedida
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['authenticated'] = true;
        
        header('Location: Aulas.php'); // Redireciona para a área logada
        exit;
    } else {
        header('Location: login.html?error=1');
        exit;
    }
}
?>