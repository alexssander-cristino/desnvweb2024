<?php

$disciplinas = [
    ["disciplina" => "Matemática", "faltas" => 5, "media" => 8.5],
    ["disciplina" => "Português", "faltas" => 2, "media" => 9],
    ["disciplina" => "Geografia", "faltas" => 10, "media" => 6],
    ["disciplina" => "Física", "faltas" => 2, "media" => 8]
];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Disciplinas</title>
</head>
<body>

<h2>Tabela de Disciplinas</h2>

<table>
    <tr>
        <th>Disciplina</th>
        <th>Faltas</th>
        <th>Média</th>
    </tr>
    <?php
    foreach ($disciplinas as $disciplina) {
        echo "<tr>";
        echo "<td>" . $disciplina["disciplina"] . "</td>";
        echo "<td>" . $disciplina["faltas"] . "</td>";
        echo "<td>" . $disciplina["media"] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>