<?php
    $precoVista = 22500;
    $parcelas = 60;
    $valorParcela = 489.65;
    $totalParcelado = $parcelas * $valorParcela;
    $juros = $totalParcelado - $precoVista;

    echo "Mariazinha pagará R$ $juros reais de juros.";
?>