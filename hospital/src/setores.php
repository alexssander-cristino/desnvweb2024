<?php
// Conexão com o banco de dados
include '../src/db.php';

// Operações de CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // Adicionar setor
    if ($acao === 'adicionar') {
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $status = $_POST['status'] ?? 'ativo';

        try {
            $sql = "INSERT INTO setores (nome, descricao, status) VALUES (:nome, :descricao, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nome' => $nome, ':descricao' => $descricao, ':status' => $status]);
            echo "Setor adicionado com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao adicionar setor: " . $e->getMessage());
        }
    }

    // Editar setor
    if ($acao === 'editar') {
        $id_setor = $_POST['id_setor'] ?? null;
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $status = $_POST['status'] ?? 'ativo';

        try {
            $sql = "UPDATE setores SET nome = :nome, descricao = :descricao, status = :status WHERE id_setor = :id_setor";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nome' => $nome, ':descricao' => $descricao, ':status' => $status, ':id_setor' => $id_setor]);
            echo "Setor atualizado com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao editar setor: " . $e->getMessage());
        }
    }

    // Excluir setor
    if ($acao === 'excluir') {
        $id_setor = $_POST['id_setor'] ?? null;

        try {
            $sql = "DELETE FROM setores WHERE id_setor = :id_setor";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_setor' => $id_setor]);
            echo "Setor excluído com sucesso!";
        } catch (PDOException $e) {
            die("Erro ao excluir setor: " . $e->getMessage());
        }
    }
}

// Recuperar setores existentes
try {
    $sqlSetores = "SELECT * FROM setores";
    $stmtSetores = $pdo->query($sqlSetores);
    $setores = $stmtSetores->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar setores: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Setores</title>
    <link rel="stylesheet" href="../public/css/setores.css"> <!-- Vincule seu arquivo CSS -->
</head>
<body>
    <h1>Gerenciar Setores</h1>

    <!-- Formulário para adicionar setor -->
    <h2>Adicionar Setor</h2>
    <form method="POST">
        <input type="hidden" name="acao" value="adicionar">
        <label for="nome">Nome do Setor:</label>
        <input type="text" name="nome" id="nome" required>
        <br>
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao"></textarea>
        <br>
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="ativo">Ativo</option>
            <option value="inativo">Inativo</option>
        </select>
        <br>
        <button type="submit">Adicionar</button>
    </form>

    <!-- Listar setores -->
    <h2>Setores Existentes</h2>
    <table >
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($setores as $setor): ?>
                <tr>
                    <td><?= htmlspecialchars($setor['id_setor']) ?></td>
                    <td><?= htmlspecialchars($setor['nome']) ?></td>
                    <td><?= htmlspecialchars($setor['descricao']) ?></td>
                    <td><?= htmlspecialchars($setor['status']) ?></td>
                    <td>
                        <!-- Botão para abrir o modal de edição -->
                        <button type="button" onclick="openEditModal(<?= $setor['id_setor'] ?>, '<?= htmlspecialchars($setor['nome']) ?>', '<?= htmlspecialchars($setor['descricao']) ?>', '<?= htmlspecialchars($setor['status']) ?>')">Editar</button>

                        <!-- Formulário para excluir -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id_setor" value="<?= htmlspecialchars($setor['id_setor']) ?>">
                            <button type="submit" onclick="return confirm('Deseja excluir este setor?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal de Edição -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Editar Setor</h2>
            <form method="POST" id="editForm">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="id_setor" id="editIdSetor">
                <label for="editNome">Nome do Setor:</label>
                <input type="text" name="nome" id="editNome" required>
                <br>
                <label for="editDescricao">Descrição:</label>
                <textarea name="descricao" id="editDescricao"></textarea>
                <br>
                <label for="editStatus">Status:</label>
                <select name="status" id="editStatus">
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
                <br>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>

    <script>
        // Função para abrir o modal de edição
        function openEditModal(id, nome, descricao, status) {
            document.getElementById('editIdSetor').value = id;
            document.getElementById('editNome').value = nome;
            document.getElementById('editDescricao').value = descricao;
            document.getElementById('editStatus').value = status;
            document.getElementById('editModal').style.display = 'block';
        }

        // Função para fechar o modal de edição
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Fecha o modal ao clicar fora da área do conteúdo
        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>
