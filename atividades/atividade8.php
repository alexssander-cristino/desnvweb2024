<?php
    $precoVista = 8654;
    $juros = [1.5, 2.0, 2.5, 3.0];
    $parcelas = [24, 36, 48, 60];

    for ($i = 0; $i < count($parcelas); $i++) {
        $montante = $precoVista * (1 + ($juros[$i] / 100) * $parcelas[$i]);
        $valorParcela = $montante / $parcelas[$i];
        echo "Para $parcelas[$i] vezes, o valor da parcela será R$ " . number_format($valorParcela, 2, ',', '.') . "<br>";
    }
?>