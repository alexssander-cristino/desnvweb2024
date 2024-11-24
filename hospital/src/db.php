<?php
// Configurações do banco de dados
$host = 'localhost'; // Host onde o banco de dados está hospedado
$dbname = 'teste'; // Nome do banco de dados
$user = "postgres"; //usuario do banco de dados
$password = 'postgre'; // Senha do banco de dados

try {
    // Cria a conexão com o banco usando PDO
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Captura erros de conexão e encerra o script
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
