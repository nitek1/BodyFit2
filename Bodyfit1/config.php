<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

sqlsrv_configure('WarningsReturnAsErrors', 0);

$serverName = getenv('BODYFIT_SQLSERVER') ?: 'localhost\\SQLEXPRESS';
$databaseName = getenv('BODYFIT_DB') ?: 'BodyFitDB';
$databaseUser = getenv('BODYFIT_DB_USER');
$databasePassword = getenv('BODYFIT_DB_PASSWORD');

$connectionOptions = [
    'Database' => $databaseName,
    'CharacterSet' => 'UTF-8',
    'TrustServerCertificate' => true,
    'LoginTimeout' => 5,
];

if ($databaseUser && $databasePassword) {
    $connectionOptions['Uid'] = $databaseUser;
    $connectionOptions['PWD'] = $databasePassword;
}

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die(
        "<h2 style='color: red; padding: 20px; background: #1a1a1a;'>Falha na conexao com o banco de dados:</h2>"
        . '<pre>' . print_r(sqlsrv_errors(), true) . '</pre>'
    );
}

function getTableData($conn, $tableName) {
    $query = "SELECT * FROM $tableName";
    $stmt = sqlsrv_query($conn, $query);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $rows = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        foreach ($row as $key => $value) {
            if ($value instanceof DateTime) {
                $row[$key] = $value->format('d/m/Y H:i');
            }
        }
        $rows[] = $row;
    }

    return $rows;
}

function getTableCount($conn, $tableName) {
    $query = "SELECT COUNT(*) AS count FROM $tableName";
    $stmt = sqlsrv_query($conn, $query);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    return $row['count'] ?? 0;
}

function getStats($conn) {
    return [
        'usuarios' => getTableCount($conn, 'usuarios'),
        'aulas' => getTableCount($conn, 'aulas'),
        'reservas' => getTableCount($conn, 'reservas'),
        'progresso' => getTableCount($conn, 'progresso'),
    ];
}

function executeQuery($conn, $query, $params = []) {
    $stmt = sqlsrv_prepare($conn, $query, $params);

    if (!$stmt) {
        $errors = sqlsrv_errors();
        error_log('Erro ao preparar consulta: ' . print_r($errors, true));
        die('Erro ao preparar consulta: ' . print_r($errors, true));
    }

    if (!sqlsrv_execute($stmt)) {
        $errors = sqlsrv_errors();
        error_log('Erro ao executar consulta: ' . print_r($errors, true));
        die('Erro ao executar consulta: ' . print_r($errors, true));
    }

    return $stmt;
}

function getUserByUsername($conn, $username) {
    $query = 'SELECT * FROM usuarios WHERE username = ?';
    $stmt = sqlsrv_prepare($conn, $query, [$username]);

    if (!$stmt) {
        return false;
    }

    if (!sqlsrv_execute($stmt)) {
        return false;
    }

    return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
}
?>
