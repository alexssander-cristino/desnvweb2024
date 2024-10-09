<?php

function calculaMediaNotas(): float|int {
        $somaNotas = 0;
        for($i = 0; $i < count(value: notas); $i++) {
            $somaNotas += notas[$i];
        }
        $mediaNotas = $somaNotas / count(value: notas);
        return $mediaNotas;
    }

    function verificaStatusNotas($mediaNotas): string {
        if($mediaNotas >= 7) {
            return "Aprovado";
        }
        return "Reprovado";
    }

    function calculaFrequencia(): float|int {
        $somaFrequencia = 0;
        for($i = 0; $i < count(value: aulas); $i++) {
            $somaFrequencia += aulas[$i];
        }
        $frequencia = 100 - (($somaFrequencia * 100) / $i);
        return $frequencia;
    }

    function verificaStatusFrequencia($frequencia): string{
        if($frequencia >= 70) {
            return "Aprovado";
        }
        return "Reprovado";
    }

    function exibeMensagem($mensagem): void {
        echo $mensagem;
    }

?>