<?php
$serverName = "NICK\\SQLEXPRESS"; // ou 127.0.0.1\SQLEXPRESS
$connectionOptions = [
    "Database" => "BodyFitDB",
    "Uid" => "php_user",
    "PWD" => "SenhaSuperSegura123"
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
    echo "<h2 style='color: green;'>✅ Conexão bem-sucedida com SQL Server usando php_user!</h2>";
} else {
    echo "<h2 style='color: red;'>❌ Falha na conexão:</h2>";
    die(print_r(sqlsrv_errors(), true));
}
?>

