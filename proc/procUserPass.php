<?php

require_once '../proc/funcBD.php';
session_start();

// Verifica se os campos das senhas nao estao vazios
if (!empty($_POST['alterarSenhaUserID']) && !empty($_POST['altSenhaUser1']) && !empty($_POST['altSenhaUser2'])) {
    $idUser         = $_POST['alterarSenhaUserID'];
    $senhaUser      = $_POST['altSenhaUser1'];
    $origem         = $_POST['origem'];

    // Proteção contra SQL Injection
    $conexao        = conectarBD();
    $senhaUser      = mysqli_real_escape_string($conexao, $senhaUser);

    //chamando funcao de atualizar a senha
    alterarSenhaUsuario($idUser, $senhaUser);
    
    // Redireciona de volta a pagina que fez o post
    if ($origem == 'perfil-user')
        header("Location: ../view/logout.php");
    if ($origem == 'ger-user') {
        $_SESSION['msg_cadastro'] = "Senha atualizada com sucesso!";
        header("Location: ../view/ger-usuarios.php");
    }
    exit;
}

if ($origem == 'ger-user')
    $_SESSION['msg_cadastro'] = "Erro ao atualizar a senha!";

// Redireciona de volta ao formulário de login
if ($origem == 'perfil-user')
    header("Location: ../view/perfil-user.php");
if ($origem == 'ger-user')
    header("Location: ../view/ger-usuarios.php");
exit;

?>