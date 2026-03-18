<?php
session_start();
require_once 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Usuário não autenticado']);
    exit;
}

// Verifica se os dados necessários foram recebidos
if (!isset($_POST['id_aula'], $_POST['nome_aula'])) {
    echo json_encode(['success' => false, 'error' => 'Dados incompletos']);
    exit;
}

$id_aula = $_POST['id_aula'];
$nome_aula = $_POST['nome_aula'];
$id_usuario = $_SESSION['user_id'];

try {
    // Registra a visualização da aula
    $query = "INSERT INTO visualizacoes_aulas (id_usuario, id_aula, nome_aula, data_visualizacao) 
              VALUES (?, ?, ?, GETDATE())";
    
    $params = array($id_usuario, $id_aula, $nome_aula);
    $stmt = sqlsrv_prepare($conn, $query, $params);
    
    if (!$stmt || !sqlsrv_execute($stmt)) {
        throw new Exception("Erro ao registrar visualização: " . print_r(sqlsrv_errors(), true));
    }

    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'error' => $e->getMessage()
    ]);
}
?>