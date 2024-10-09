<?php

$disciplinas = array(
    "Segunda-feira" => "Algoritmos 2",
    "Terça-feira" => "Banco de Dados 2",
    "Quarta-feira" => "Administração de Sistemas de Informação",
    "Quinta-feira" => "Engenharia de Software 2",
    "Sexta-feira" => "Programação Web I"
);

$professores = array(
    "Segunda-feira" => "Prof. Fernando",
    "Terça-feira" => "Prof. Marco",
    "Quarta-feira" => "Prof. Sandro",
    "Quinta-feira" => "Prof. Jullian",
    "Sexta-feira" => "Prof. Cleber"
);

for ($i = 0; $i < 5; $i++) {
    $dia = array_keys($disciplinas)[$i]; 
    $disciplina = $disciplinas[$dia]; 
    $professor = $professores[$dia]; 

    echo "Disciplina " . $disciplina . ", professor " . $professor . ".<br>";
}

?>