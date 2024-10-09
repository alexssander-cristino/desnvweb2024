<?php
    $precoVista = 8654;
    $juros = [2.0, 2.3, 2.6, 2.9];
    $parcelas = [24, 36, 48, 60];

    for ($i = 0; $i < count($parcelas); $i++) {
        $montante = $precoVista * pow((1 + $juros[$i] / 100), $parcelas[$i]);
        $valorParcela = $montante / $parcelas[$i];
        echo "Para $parcelas[$i] vezes, o valor da parcela com juros compostos será R$ " . number_format($valorParcela, 2, ',', '.') . "<br>";
    }
?>