<?php
    $dinheiro = 50;
    $compra = [
        'maçã' => 3,
        'melancia' => 7,
        'laranja' => 4,
        'repolho' => 2,
        'cenoura' => 1,
        'batatinha' => 2
    ];
    $precos = [
        'maçã' => 5,
        'melancia' => 12,
        'laranja' => 3,
        'repolho' => 2,
        'cenoura' => 4,
        'batatinha' => 6
    ];

    $total = 0;
    foreach ($compra as $produto => $kg) {
        $total += $precos[$produto] * $kg;
    }

    if ($total < $dinheiro) {
        echo "<p style='color: blue;'>Você ainda pode gastar " . ($dinheiro - $total) . " reais.</p>";
    } elseif ($total == $dinheiro) {
        echo "<p style='color: green;'>O saldo para compras foi esgotado.</p>";
    } else {
        echo "<p style='color: red;'>Faltam " . ($total - $dinheiro) . " reais.</p>";
    }
?>