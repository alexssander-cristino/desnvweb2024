<?php 

    //Declarar arrays de dados como variáveis de escopo global
    define("notas", array(6, 8, 10, 7));
    define("aulas", array(0, 1, 0, 0, 1, 0, 0, 1, 0, 0));
    
    function calculaMediaNotas() {
        $somaNotas = 0;
        for($i = 0; $i < count(notas); $i++) {
            $somaNotas += notas[$i];
        }
        $mediaNotas = $somaNotas / count(notas);
        return $mediaNotas;
    }

    function verificaStatusNotas($mediaNotas) {
        if($mediaNotas >= 7) {
            return "Aprovado";
        }
        return "Reprovado";
    }

    function calculaFrequencia() {
        $somaFrequencia = 0;
        for($i = 0; $i < count(aulas); $i++) {
            $somaFrequencia += aulas[$i];
        }
        $frequencia = 100 - (($somaFrequencia * 100) / $i);
        return $frequencia;
    }

    function verificaStatusFrequencia($frequencia){
        if($frequencia >= 70) {
            return "Aprovado";
        }
        return "Reprovado";
    }

    function exibeMensagem($mensagem) {
        echo $mensagem;
    }

    $mediaNotas = calculaMediaNotas();
    $frequencia = calculaFrequencia();

    exibeMensagem("Média de Notas: " . $mediaNotas . "<br>" .
                  "Status Nota: " . verificaStatusNotas($mediaNotas) . "<br>" . 
                  "Frequencia: " . $frequencia . "<br>" .
                  "Status Frequencia: " . verificaStatusFrequencia($frequencia) . "<br>");
?>