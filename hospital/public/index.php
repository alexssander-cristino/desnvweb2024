<?php
// Conexão com o banco
include '../src/db.php';

// Obtendo o ID do dispositivo via URL
$id_dispositivo = $_GET['id_dispositivo'] ?? null;

if (!$id_dispositivo) {
    die('ID do dispositivo não especificado.');
}

// Carregando perguntas ativas vinculadas ao dispositivo
try {
    $sql = "
        SELECT p.id_pergunta, p.texto 
        FROM perguntas p
        WHERE p.id_dispositivo = :id_dispositivo AND p.status = 'ativa'
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_dispositivo' => $id_dispositivo]);
    $perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erro ao buscar perguntas: ' . $e->getMessage());
}

// Verificando se há perguntas para exibir
if (empty($perguntas)) {
    die('Nenhuma pergunta ativa disponível para este dispositivo.');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação Hospital</title>
    <link rel="stylesheet" href="../public/css/index.css">
</head>
<body>
    <h1>Avaliação dos Serviços do Hospital</h1>
    <form action="../src/processar_avaliacao.php" method="POST">
        <!-- Campo oculto para enviar o ID do dispositivo -->
        <input type="hidden" name="id_dispositivo" value="<?= htmlspecialchars($id_dispositivo) ?>">

        <!-- Gerar perguntas dinâmicas -->
        <?php foreach ($perguntas as $pergunta): ?>
            <div class="nota">
    <p><?= htmlspecialchars($pergunta['texto']) ?></p>
    <div class="notas-container">
    <label class="nota-botao red">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="0">
        0
    </label>
    <label class="nota-botao red">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="1">
        1
    </label>
    <label class="nota-botao red">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="2">
        2
    </label>
    <label class="nota-botao red">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="3">
        3
    </label>
    <label class="nota-botao yellow">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="4">
        4
    </label>
    <label class="nota-botao yellow">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="5">
        5
    </label>
    <label class="nota-botao yellow">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="6">
        6
    </label>
    <label class="nota-botao green">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="7">
        7
    </label>
    <label class="nota-botao green">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="8">
        8
    </label>
    <label class="nota-botao green">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="9">
        9
    </label>
    <label class="nota-botao green">
        <input type="radio" name="avaliacao_<?= $pergunta['id_pergunta'] ?>" value="10">
        10
    </label>
</div>


        <?php endforeach; ?>

        <!-- Feedback textual -->
        <div>
            <label class="fedd" for="feedback">Feedback adicional (opcional):</label>
            <textarea id="feedback" name="feedback" rows="4" cols="50"></textarea>
        </div>

        <button type="submit">Enviar Avaliação</button>
    </form>
</body>
</html>
