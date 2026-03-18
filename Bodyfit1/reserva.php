<?php
session_start();
require_once 'auth_check.php'; 
require_once 'config.php';


// Verificar se o usuário está logado
if (!isset($_SESSION['authenticated']) || !isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_aula'])) {
    try {
        $id_usuario = $_SESSION['user_id'];
        $id_aula = $_POST['id_aula'];
        $data_reserva = date('Y-m-d H:i:s'); // Data e hora atual

        $query = "INSERT INTO reservas (id_usuario, id_aula, data_reserva) VALUES (?, ?, ?)";
        $params = array($id_usuario, $id_aula, $data_reserva);
        
        executeQuery($conn, $query, $params);
        
        // Se for requisição AJAX, retornar JSON
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode(['success' => true]);
            exit;
        }
        
        // Redirecionar de volta com mensagem de sucesso
        $_SESSION['reserva_success'] = "Aula reservada com sucesso!";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
        
    } catch (Exception $e) {
        // Tratar erro
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
        
        $_SESSION['reserva_error'] = "Erro ao reservar aula: " . $e->getMessage();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

// Se não for POST ou faltar parâmetros
header('Location: Aulas.php');
exit;
?>