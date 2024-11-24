<?php
// Conexão com o banco de dados
include '../src/db.php';

// Carregar dispositivos para exibir no formulário
try {
    $sql = "SELECT id_dispositivo, nome FROM dispositivos WHERE status = 'ativo'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $dispositivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erro ao buscar dispositivos: ' . $e->getMessage());
}

// Processar o formulário de cadastro de pergunta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])) {
    $id_dispositivo = $_POST['id_dispositivo'] ?? null;
    $texto_pergunta = $_POST['texto_pergunta'] ?? null;

    if (!$id_dispositivo || !$texto_pergunta) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        try {
            $sql = "INSERT INTO perguntas (texto, status, id_dispositivo) VALUES (:texto, 'ativa', :id_dispositivo)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'texto' => $texto_pergunta,
                'id_dispositivo' => $id_dispositivo
            ]);
            $sucesso = "Pergunta cadastrada com sucesso!";
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar pergunta: " . $e->getMessage();
        }
    }
}

// Alterar o status de uma pergunta
if (isset($_GET['acao']) && $_GET['acao'] === 'alterar_status' && isset($_GET['id_pergunta'])) {
    $id_pergunta = $_GET['id_pergunta'];

    try {
        // Obter o status atual
        $sql = "SELECT status FROM perguntas WHERE id_pergunta = :id_pergunta";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_pergunta' => $id_pergunta]);
        $pergunta = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pergunta) {
            // Alterar o status
            $novo_status = ($pergunta['status'] === 'ativa') ? 'inativa' : 'ativa';
            $sql = "UPDATE perguntas SET status = :status WHERE id_pergunta = :id_pergunta";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['status' => $novo_status, 'id_pergunta' => $id_pergunta]);
            $sucesso = "Status alterado com sucesso!";
        } else {
            $erro = "Pergunta não encontrada.";
        }
    } catch (PDOException $e) {
        $erro = "Erro ao alterar o status: " . $e->getMessage();
    }
}

// Carregar perguntas para exibição
try {
    $sql = "
        SELECT p.id_pergunta, p.texto, p.status, d.nome AS dispositivo_nome
        FROM perguntas p
        JOIN dispositivos d ON p.id_dispositivo = d.id_dispositivo
        ORDER BY p.id_pergunta DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erro ao buscar perguntas: ' . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar e Gerenciar Perguntas</title>
    <link rel="stylesheet" href="../public/css/perguntas.css">
</head>
<body>
    <h1>Gerenciar Perguntas</h1>

    <!-- Exibir mensagens de erro ou sucesso -->
    <?php if (isset($erro)): ?>
        <div style="color: red;"><?= htmlspecialchars($erro) ?></div>
    <?php elseif (isset($sucesso)): ?>
        <div style="color: green;"><?= htmlspecialchars($sucesso) ?></div>
    <?php endif; ?>

    <!-- Formulário para cadastrar pergunta -->
    <form action="" method="POST">
        <div class="selecao">
            <label for="id_dispositivo">Dispositivo:</label>
            <select name="id_dispositivo" id="id_dispositivo" required>
                <option value="">Selecione um dispositivo</option>
                <?php foreach ($dispositivos as $dispositivo): ?>
                    <option value="<?= htmlspecialchars($dispositivo['id_dispositivo']) ?>">
                        <?= htmlspecialchars($dispositivo['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="feddback">
            <label for="texto_pergunta">Texto da Pergunta:</label>
            <textarea name="texto_pergunta" id="texto_pergunta" rows="4" cols="50" required></textarea>
        </div>

        <button type="submit" name="cadastrar">Cadastrar Pergunta</button>
    </form>

    <hr>

    <!-- Tabela de perguntas -->
    <h2>Lista de Perguntas</h2>
    <table >
        <thead>
            <tr>
                <th>ID</th>
                <th>Pergunta</th>
                <th>Dispositivo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($perguntas)): ?>
                <?php foreach ($perguntas as $pergunta): ?>
                    <tr>
                        <td><?= htmlspecialchars($pergunta['id_pergunta']) ?></td>
                        <td><?= htmlspecialchars($pergunta['texto']) ?></td>
                        <td><?= htmlspecialchars($pergunta['dispositivo_nome']) ?></td>
                        <td><?= htmlspecialchars($pergunta['status']) ?></td>
                        <td>
                            <a href="?acao=alterar_status&id_pergunta=<?= htmlspecialchars($pergunta['id_pergunta']) ?>">
                                Alterar para <?= $pergunta['status'] === 'ativa' ? 'Inativa' : 'Ativa' ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhuma pergunta cadastrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
