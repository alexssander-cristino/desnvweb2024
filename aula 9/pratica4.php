<?php

function calcularValorFinal($valor, $desconto) {
    if (!is_numeric($valor) || !is_numeric($desconto)) {
        throw new Exception("Os parâmetros devem ser numéricos.");
    }
    
    if ($valor <= 0) {
        throw new Exception("O valor deve ser maior que zero.");
    }
    
    if ($desconto < 0 || $desconto > 100) {
        throw new Exception("O desconto deve estar entre 0 e 100.");
    }

    $valorFinal = $valor - ($valor * ($desconto / 100));
    return $valorFinal;
}

try {

    if (!isset($_REQUEST['valor']) || !isset($_REQUEST['desconto'])) {
        throw new Exception("Parâmetros 'valor' e 'desconto' são obrigatórios.");
    }

    $valor = $_REQUEST['valor'];
    $desconto = $_REQUEST['desconto'];

    $valorFinal = calcularValorFinal($valor, $desconto);

    echo "Valor final após desconto: R$ " . number_format($valorFinal, 2);
    
} catch (Exception $e) {

    echo "Erro: " . $e->getMessage();
}

?>