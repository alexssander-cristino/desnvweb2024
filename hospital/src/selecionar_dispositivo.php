<?php
// Conexão com o banco de dados
include '../src/db.php';

// Carregando todos os dispositivos ativos
try {
    $sql = "SELECT id_dispositivo, nome FROM dispositivos WHERE status = 'ativo'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $dispositivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erro ao carregar dispositivos: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Dispositivo para Avaliação</title>
    <link rel="stylesheet" href="../public/css/selecionar_disp.css">
</head>
<body>
    <h1>Selecione um Dispositivo para Avaliar</h1>

    <!-- Formulário para selecionar dispositivo -->
    <form action="../public/index.php" method="GET">
        <label for="id_dispositivo">Escolha um dispositivo:</label>
        <select name="id_dispositivo" id="id_dispositivo" required>
            <option value="">Selecione...</option>
            <?php foreach ($dispositivos as $dispositivo): ?>
                <option value="<?= htmlspecialchars($dispositivo['id_dispositivo']) ?>">
                    <?= htmlspecialchars($dispositivo['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Selecionar</button>
    </form>

    <!-- Botão para ir para a página de administração -->
    <br><br>
    <a href="painel.php">
        <button type="button">Ir para Administração</button>
    </a>
</body>
</html>
