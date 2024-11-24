<?php
// Conexão com o banco de dados
include '../src/db.php';

// Operações de CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // Adicionar dispositivo
    if ($acao === 'adicionar') {
        $nome = $_POST['nome'] ?? '';
        $id_setor = $_POST['id_setor'] ?? null;
        $status = $_POST['status'] ?? 'ativo';

        try {
            $sql = "INSERT INTO dispositivos (nome, id_setor, status) VALUES (:nome, :id_setor, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nome' => $nome, ':id_setor' => $id_setor, ':status' => $status]);
            echo "Dispositivo adicionado com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao adicionar dispositivo: " . $e->getMessage());
        }
    }

    // Editar dispositivo
    if ($acao === 'editar') {
        $id_dispositivo = $_POST['id_dispositivo'] ?? null;
        $nome = $_POST['nome'] ?? '';
        $id_setor = $_POST['id_setor'] ?? null;
        $status = $_POST['status'] ?? 'ativo';

        try {
            $sql = "UPDATE dispositivos SET nome = :nome, id_setor = :id_setor, status = :status WHERE id_dispositivo = :id_dispositivo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nome' => $nome, ':id_setor' => $id_setor, ':status' => $status, ':id_dispositivo' => $id_dispositivo]);
            echo "Dispositivo atualizado com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao editar dispositivo: " . $e->getMessage());
        }
    }

    // Excluir dispositivo
    if ($acao === 'excluir') {
        $id_dispositivo = $_POST['id_dispositivo'] ?? null;

        try {
            $sql = "DELETE FROM dispositivos WHERE id_dispositivo = :id_dispositivo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_dispositivo' => $id_dispositivo]);
            echo "Dispositivo excluído com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao excluir dispositivo: " . $e->getMessage());
        }
    }
}

// Recuperar dispositivos e setores
try {
    $sqlDispositivos = "SELECT d.*, s.nome AS setor_nome FROM dispositivos d LEFT JOIN setores s ON d.id_setor = s.id_setor";
    $stmtDispositivos = $pdo->query($sqlDispositivos);
    $dispositivos = $stmtDispositivos->fetchAll(PDO::FETCH_ASSOC);

    $sqlSetores = "SELECT * FROM setores WHERE status = 'ativo'";
    $stmtSetores = $pdo->query($sqlSetores);
    $setores = $stmtSetores->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Dispositivos</title>
    <link rel="stylesheet" href="../public/css/dispositivo.css">
    <script>
        // Função para abrir o modal
        function openModal(id) {
            var modal = document.getElementById("modal_" + id);
            modal.style.display = "block";
        }

        // Função para fechar o modal
        function closeModal(id) {
            var modal = document.getElementById("modal_" + id);
            modal.style.display = "none";
        }

        // Fechar o modal se o usuário clicar fora dele
        window.onclick = function(event) {
            var modals = document.getElementsByClassName("modal");
            for (var i = 0; i < modals.length; i++) {
                if (event.target === modals[i]) {
                    modals[i].style.display = "none";
                }
            }
        }
    </script>
</head>
<body>
    <h1>Gerenciar Dispositivos</h1>

    <!-- Formulário para adicionar dispositivo -->
    <h2>Adicionar Dispositivo</h2>
    <form method="POST">
        <input type="hidden" name="acao" value="adicionar">
        <label for="nome">Nome do Dispositivo:</label>
        <input type="text" name="nome" id="nome" required>
        <br>
        <label for="id_setor">Setor:</label>
        <select name="id_setor" id="id_setor" required>
            <option value="">Selecione um setor</option>
            <?php foreach ($setores as $setor): ?>
                <option value="<?= htmlspecialchars($setor['id_setor']) ?>"><?= htmlspecialchars($setor['nome']) ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="ativo">Ativo</option>
            <option value="inativo">Inativo</option>
        </select>
        <br>
        <button type="submit">Adicionar</button>
    </form>

    <!-- Listar dispositivos -->
    <h2>Dispositivos Existentes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Setor</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dispositivos as $dispositivo): ?>
                <tr>
                    <td><?= htmlspecialchars($dispositivo['id_dispositivo']) ?></td>
                    <td><?= htmlspecialchars($dispositivo['nome']) ?></td>
                    <td><?= htmlspecialchars($dispositivo['setor_nome'] ?? 'Sem setor') ?></td>
                    <td><?= htmlspecialchars($dispositivo['status']) ?></td>
                    <td>
                        <!-- Botão para abrir o modal de edição -->
                        <button type="button" onclick="openModal(<?= htmlspecialchars($dispositivo['id_dispositivo']) ?>)">Editar</button>
                        
                        <!-- Modal de edição -->
                        <div id="modal_<?= htmlspecialchars($dispositivo['id_dispositivo']) ?>" class="modal">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal(<?= htmlspecialchars($dispositivo['id_dispositivo']) ?>)">&times;</span>
                                <h2>Editar Dispositivo</h2>
                                <form method="POST">
                                    <input type="hidden" name="acao" value="editar">
                                    <input type="hidden" name="id_dispositivo" value="<?= htmlspecialchars($dispositivo['id_dispositivo']) ?>">
                                    <h2 class="name_">Nome:</h2> <input type="text" name="nome" value="<?= htmlspecialchars($dispositivo['nome']) ?>" required>
                                    <br>
                                    <h2 class="setor_">Setor:</h2>
                                    <select name="id_setor">
                                        <option value="">Selecione um setor</option>
                                        <?php foreach ($setores as $setor): ?>
                                            <option value="<?= htmlspecialchars($setor['id_setor']) ?>" <?= $setor['id_setor'] == $dispositivo['id_setor'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($setor['nome']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <br>
                                    <h2 class="status_">Status:</h2>
                                    <select name="status">
                                        <option value="ativo" <?= $dispositivo['status'] === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                                        <option value="inativo" <?= $dispositivo['status'] === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                                    </select>
                                    <br>
                                    <button type="submit">Salvar</button>
                                </form>
                            </div>
                        </div>

                        <!-- Formulário para excluir -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id_dispositivo" value="<?= htmlspecialchars($dispositivo['id_dispositivo']) ?>">
                            <button type="submit" onclick="return confirm('Deseja excluir este dispositivo?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>


