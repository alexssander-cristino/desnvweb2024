<?php
    $valor1 = 15;
    $valor2 = 5;
    $valor3 = 8;
    $resultado = $valor1 + $valor2 + $valor3;

    if ($valor1 > 10) {
        echo "<p style='color: blue;'>Resultado: $resultado</p>";
    }
    if ($valor2 < $valor3) {
        echo "<p style='color: green;'>Resultado: $resultado</p>";
    }
    if ($valor3 < $valor1 && $valor2) {
        echo "<p style='color: red;'>Resultado: $resultado</p>";
    }
?>