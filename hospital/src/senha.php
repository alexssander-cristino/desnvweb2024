<?php
require '../src/db.php';// Inclui a conexão com o banco de dados

// Defina o login do administrador e a nova senha
$usuario = 'admin'; // Substitua por seu login de administrador
$novaSenha = 'admin'; // Substitua pela senha desejada

// Gera o hash da senha
$senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

// Atualiza a senha no banco de dados
$stmt = $pdo->prepare("UPDATE usuarios_admin SET senha = :senha WHERE login = :login");
$stmt->execute(['senha' => $senhaHash, 'login' => $usuario]);

echo "Senha atualizada com sucesso!";
?>