<?php
require_once 'config.php';

echo "<h2 style='color:green;'>Conectado com sucesso ao banco BodyFitDB!</h2>";

$query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'";
$stmt = sqlsrv_query($conn, $query);

if ($stmt) {
    echo '<h3>Tabelas encontradas:</h3><ul>';
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo '<li>' . htmlspecialchars($row['TABLE_NAME']) . '</li>';
    }
    echo '</ul>';
} else {
    echo "<p style='color:orange;'>Nao foi possivel listar tabelas.</p>";
}

sqlsrv_close($conn);
?>
