<?php
// Conexão com o banco de dados
include '../src/db.php';

// Carregando informações gerais para o dashboard
try {
    // Contando avaliações realizadas
    $sql_avaliacoes = "SELECT COUNT(*) FROM avaliacoes";
    $stmt = $pdo->prepare($sql_avaliacoes);
    $stmt->execute();
    $total_avaliacoes = $stmt->fetchColumn();

    // Carregando dispositivos ativos
    $sql_dispositivos = "SELECT COUNT(*) FROM dispositivos WHERE status = 'ativo'";
    $stmt = $pdo->prepare($sql_dispositivos);
    $stmt->execute();
    $total_dispositivos = $stmt->fetchColumn();

    // Carregando setores ativos
    $sql_setores = "SELECT COUNT(*) FROM setores WHERE status = 'ativo'";
    $stmt = $pdo->prepare($sql_setores);
    $stmt->execute();
    $total_setores = $stmt->fetchColumn();
    
} catch (PDOException $e) {
    die('Erro ao carregar dados: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="../public/css/painel.css">
</head>
<body>
    <h1>Painel de Administração</h1>

    <div>
        <h2>Visão Geral</h2>
        <p><strong>Total de Avaliações Realizadas:</strong> <?= htmlspecialchars($total_avaliacoes) ?></p>
        <p><strong>Total de Dispositivos Ativos:</strong> <?= htmlspecialchars($total_dispositivos) ?></p>
        <p><strong>Total de Setores Ativos:</strong> <?= htmlspecialchars($total_setores) ?></p>
    </div>

    <div>
        <h2>Gerenciamento</h2>
        <ul>
            <li><a href="dispositivos.php">Gerenciar Dispositivos</a></li>
            <li><a href="setores.php">Gerenciar Setores</a></li>
            <li><a href="perguntas.php">Gerenciar Perguntas</a></li>
            <li><a href="processar_avaliacao.php">Visualizar Avaliações</a></li>
        </ul>
    </div>
    <br>
    <a href="logout.php">
        <button type="button">Sair</button>
    </a>
</body>
</html>
