<?php
// Conexão com o banco de dados
include '../src/db.php';

// Iniciar a sessão para armazenar o login
session_start();

// Verificando se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Validando os campos de login e senha
    if (empty($login) || empty($senha)) {
        $erro = 'Preencha todos os campos.';
    } else {
        try {
            // Verificar se o login existe no banco de dados
            $sql = "SELECT * FROM usuarios_admin WHERE login = :login LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['login' => $login]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificando se o usuário foi encontrado e se a senha corresponde ao hash
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Iniciar a sessão e redirecionar para a área administrativa
                $_SESSION['usuario'] = $usuario['login'];
                header('Location: selecionar_dispositivo.php'); // Substitua pelo caminho da sua página principal
                exit;
            } else {
                $erro = 'Usuário ou senha inválidos.';
            }
        } catch (PDOException $e) {
            $erro = 'Erro ao acessar o banco de dados: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login de Administrador</h1>
    <form action="login.php" method="POST">
        <div>
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required>
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
        </div>

        <?php if (isset($erro)): ?>
            <div style="color: red;">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <div>
            <button type="submit">Entrar</button>
        </div>
    </form>
</body>
</html>
