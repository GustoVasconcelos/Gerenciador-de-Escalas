<?php

require_once '../proc/funcBD.php';
session_start();

// Verifica se os dados do cadastro nao estao vazios
if (!empty($_POST['nomeUser']) && !empty($_POST['sobrenomeUser']) && !empty($_POST['emailUser'])) {
    $nomeUser       = $_POST['nomeUser'];
    $sobrenomeUser  = $_POST['sobrenomeUser'];
    $emailUser      = $_POST['emailUser'];
    $adminUser      = isset($_POST['checkAdm']) ? 1 : 0;

    // Proteção contra SQL Injection
    $conexao        = conectarBD();
    $nomeUser       = mysqli_real_escape_string($conexao, $nomeUser);
    $sobrenomeUser  = mysqli_real_escape_string($conexao, $sobrenomeUser);
    $emailUser      = mysqli_real_escape_string($conexao, $emailUser);

    //colocar validacao de email depois

    //chamando funcao de criar usuario
    cadastrarUsuario($nomeUser, $sobrenomeUser, $emailUser, $adminUser);

    $_SESSION['msg_cadastro'] = "Cadastrado com sucesso!";
    
    // Redireciona de volta a pagina de admin
    header("Location: ../view/ger-usuarios.php");
    exit;
}

$_SESSION['msg_cadastro'] = "Erro no cadastro!";

// Redireciona de volta ao formulário de login
header("Location: ../view/ger-usuarios.php");
exit;

?>