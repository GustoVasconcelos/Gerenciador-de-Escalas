<?php

require_once '../proc/funcBD.php';
session_start();

// Verifica se os dados alterados nao estao vazios
if (!empty($_POST['alterarUserID']) && !empty($_POST['altNomeUser']) && !empty($_POST['altSobrenomeUser']) && !empty($_POST['altEmailUser'])) {
    $idUser         = $_POST['alterarUserID'];
    $nomeUser       = $_POST['altNomeUser'];
    $sobrenomeUser  = $_POST['altSobrenomeUser'];
    $emailUser      = $_POST['altEmailUser'];
    $adminUser      = isset($_POST['altCheckAdm']) ? 1 : 0;

    // Proteção contra SQL Injection
    $conexao        = conectarBD();
    $nomeUser       = mysqli_real_escape_string($conexao, $nomeUser);
    $sobrenomeUser  = mysqli_real_escape_string($conexao, $sobrenomeUser);
    $emailUser      = mysqli_real_escape_string($conexao, $emailUser);

    //chamando funcao de alterar usuario
    alterarUsuario($idUser, $nomeUser, $sobrenomeUser, $emailUser, $adminUser);

    $_SESSION['msg_cadastro'] = "Cadastrado atualizado com sucesso!";
    
    // Redireciona de volta a pagina de admin
    header("Location: ../view/ger-usuarios.php");
    exit;
}

$_SESSION['msg_cadastro'] = "Erro ao atualizar o cadastro!";

// Redireciona de volta ao formulário de login
header("Location: ../view/ger-usuarios.php");
exit;

?>