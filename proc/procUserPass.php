<?php

require_once '../proc/funcBD.php';
session_start();

// Verifica se os campos das senhas nao estao vazios
if (!empty($_POST['alterarSenhaUserID']) && !empty($_POST['altSenhaUser1']) && !empty($_POST['altSenhaUser2'])) {
    $idUser       = $_POST['alterarSenhaUserID'];
    $senhaUser    = $_POST['altSenhaUser1'];

    // Proteção contra SQL Injection
    $conexao        = conectarBD();
    $senhaUser      = mysqli_real_escape_string($conexao, $senhaUser);

    //chamando funcao de atualizar a senha
    alterarSenhaUsuario($idUser, $senhaUser);

    $_SESSION['msg_cadastro'] = "Senha atualizada com sucesso!";
    
    // Redireciona de volta a pagina de admin
    header("Location: ../view/ger-usuarios.php");
    exit;
}

$_SESSION['msg_cadastro'] = "Erro ao atualizar a senha!";

// Redireciona de volta ao formulário de login
header("Location: ../view/ger-usuarios.php");
exit;

?>