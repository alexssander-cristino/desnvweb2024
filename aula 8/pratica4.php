<?php

$salario1 = 1000;
$salario2 = 5000;

for ($i = 1; $i <= 100; $i++) {
    $salario1 += 1;
    
    if ($i == 50) {
        break;
    }
}

if ($salario1 < $salario2) {
    echo "O valor de SALARIO1 ($salario1) é menor do que o valor de SALARIO2 ($salario2).";
} else {
    echo "O valor de SALARIO1 ($salario1) não é menor do que o valor de SALARIO2 ($salario2).";
}
?>