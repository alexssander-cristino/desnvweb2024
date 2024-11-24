<?php
// Conexão com o banco de dados
include 'db.php';

// Verifica se o ID do dispositivo foi enviado
$id_dispositivo = $_POST['id_dispositivo'] ?? null;

if (!$id_dispositivo) {
    die('ID do dispositivo não especificado.');
}

// Inicializa variáveis para armazenar resultados
$respostas_processadas = [];
$feedback_textual = $_POST['feedback'] ?? null;

try {
    // Inicia uma transação
    $pdo->beginTransaction();

    // Percorre todas as perguntas respondidas
    foreach ($_POST as $key => $value) {
        // Identifica os campos relacionados às avaliações
        if (strpos($key, 'avaliacao_') === 0) {
            $id_pergunta = str_replace('avaliacao_', '', $key);
            $resposta = (int) $value;

            // Obter o setor vinculado ao dispositivo (necessário para a tabela `avaliacoes`)
            $sqlSetor = "SELECT id_setor FROM dispositivos WHERE id_dispositivo = :id_dispositivo";
            $stmtSetor = $pdo->prepare($sqlSetor);
            $stmtSetor->execute(['id_dispositivo' => $id_dispositivo]);
            $setor = $stmtSetor->fetch(PDO::FETCH_ASSOC);

            if (!$setor) {
                throw new Exception('Setor não encontrado para o dispositivo especificado.');
            }

            $id_setor = $setor['id_setor'];

            // Salvar a avaliação no banco de dados
            $sqlInsert = "
                INSERT INTO avaliacoes (id_setor, id_dispositivo, id_pergunta, resposta, feedback_textual)
                VALUES (:id_setor, :id_dispositivo, :id_pergunta, :resposta, :feedback_textual)
            ";

            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->execute([
                'id_setor' => $id_setor,
                'id_dispositivo' => $id_dispositivo,
                'id_pergunta' => $id_pergunta,
                'resposta' => $resposta,
                'feedback_textual' => $feedback_textual,
            ]);

            // Armazenar a resposta processada para exibição
            $respostas_processadas[] = [
                'id_pergunta' => $id_pergunta,
                'resposta' => $resposta,
            ];
        }
    }

    // Confirma a transação
    $pdo->commit();

} catch (Exception $e) {
    // Reverte a transação em caso de erro
    $pdo->rollBack();
    die('Erro ao processar as avaliações: ' . $e->getMessage());
}

// Página de agradecimento
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obrigado!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .agradecimento {
            max-width: 500px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
        .agradecimento h1 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .agradecimento p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .agradecimento a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .agradecimento a:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        // Configura o redirecionamento automático após 5 segundos
        const redirectionUrl = "../public/index.php?id_dispositivo=<?= htmlspecialchars($id_dispositivo) ?>";
        const countdownTime = 5; // Tempo em segundos
        let countdown = countdownTime;

        // Função de contagem regressiva
        function startCountdown() {
            const timerElement = document.getElementById('timer');
            const interval = setInterval(() => {
                countdown--;
                timerElement.textContent = countdown;

                if (countdown <= 0) {
                    clearInterval(interval);
                    window.location.href = redirectionUrl;
                }
            }, 1000);
        }

        // Inicia o temporizador assim que a página carrega
        window.onload = startCountdown;
    </script>
</head>
<body>
    <div class="agradecimento">
        <h1>Obrigado pela sua avaliação!</h1>
        <p>Sua opinião é muito importante para nós.</p>
        <p>Você será redirecionado em <span id="timer">5</span> segundos...</p>
        <a href="../public/index.php?id_dispositivo=<?= htmlspecialchars($id_dispositivo) ?>">Clique aqui caso não seja redirecionado automaticamente</a>
    </div>
</body>
</html>
