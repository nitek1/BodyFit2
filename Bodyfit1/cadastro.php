<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_completo = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $plano = 'Básico';

    // Usa a função executeQuery do config.php
    $query = "INSERT INTO usuarios (nome_completo, email, username, senha, plano) VALUES (?, ?, ?, ?, ?)";
    $params = array($nome_completo, $email, $username, $password, $plano);
    
    if (executeQuery($conn, $query, $params)) {
        header('Location: login.html?success=1');
        exit;
    } else {
        header('Location: Cadastro.html?error=1');
        exit;
    }
}
?>