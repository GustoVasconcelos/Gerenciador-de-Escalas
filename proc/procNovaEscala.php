<?php

require_once '../proc/funcBD.php';
session_start();

// Configurar localização para português
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// verifica se as datas foram enviadas
if (!empty($_POST['dataInicial']) && !empty($_POST['dataFinal'])) {

    // Receber e validar os dados do POST
    if (empty($_POST['dataInicial']) || empty($_POST['dataFinal'])) {
        die("Erro: Ambas as datas devem ser preenchidas!");
    }

    $dataInicial    = $_POST['dataInicial'];
    $dataFinal      = $_POST['dataFinal'];
    $temFerias      = isset($_POST['temFerias']) ? 1 : 0;
    $funcFerias     = $_POST['selectTemFerias'];

    if($temFerias == 1) {
        $dtInicioFerias = $_POST['dtInicioFerias'];
        $dtFinalFerias  = $_POST['dtFinalFerias'];
    }

    // Validar formato das datas
    if (!strtotime($dataInicial) || !strtotime($dataFinal)) {
        die("Erro: Formato de data inválido! Use o formato AAAA-MM-DD.");
    }

    // Converter para objetos DateTime
    $dataInicialObj = DateTime::createFromFormat('Y-m-d', $dataInicial);
    $dataFinalObj = DateTime::createFromFormat('Y-m-d', $dataFinal);

    if (!$dataInicialObj || !$dataFinalObj) {
        die("Erro: Datas inválidas!");
    }

    // Verificar se data final é maior ou igual à inicial
    if ($dataFinalObj < $dataInicialObj) {
        die("Erro: A data final deve ser maior ou igual à data inicial!");
    }

    // Processar o intervalo de datas
    $intervalo = new DateInterval('P1D');
    $periodo = new DatePeriod($dataInicialObj, $intervalo, $dataFinalObj->modify('+1 day'));

    $_SESSION['dadosEscala'] = [
        'dataInicial'   => $dataInicial,
        'dataFinal'     => $dataFinal,
        'periodo'       => $periodo,
        'temFerias'     => $temFerias,
        'funcFerias'    => $funcFerias
    ];

    header("Location: ../view/nova_escala.php");
    exit;
}

// Redireciona de volta ao formulário de login
//header("Location: ../view/login.php");
//exit;

?>