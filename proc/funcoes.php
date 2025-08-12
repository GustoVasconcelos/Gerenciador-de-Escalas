<?php

// Função para traduzir os dias da semana
function traduzirDiaSemana($dataObj) {
    $diasIngles = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $diasPortugues = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

    $diaIngles = $dataObj->format('l');
    $indice = array_search($diaIngles, $diasIngles);        
    return $diasPortugues[$indice] ?? $diaIngles;
}

?>