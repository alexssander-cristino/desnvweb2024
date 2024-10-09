<?php
    $array = [
        "Pai" => [
            "Filho 1" => [
                "Neto 1" => [],
                "Neto 2" => []
            ],
            "Filho 2" => [
                "Neto 3" => [],
                "Neto 4" => []
            ]
        ]
    ];
    
    function exibeArvore($array, $nivel = 0) {
        foreach ($array as $chave => $valor) {
            echo str_repeat("--", $nivel) . $chave . "<br>";
            if (is_array($valor)) {
                exibeArvore($valor, $nivel + 1);
            }
        }
    }

    exibeArvore($array);
?>