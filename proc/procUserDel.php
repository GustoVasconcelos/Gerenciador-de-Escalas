<?php

require_once '../proc/funcBD.php';
session_start();

// Verifica se os dados do cadastro nao estao vazios
if (!empty($_POST['excluiUserID'])) {
    $idUser = $_POST['excluiUserID'];

    //chamando funcao de excluir usuario
    excluirUsuario($idUser);

    $_SESSION['msg_cadastro'] = "Usuario excluido com sucesso!";
    
    // Redireciona de volta a pagina de admin
    header("Location: ../view/ger-usuarios.php");
    exit;
}

$_SESSION['msg_cadastro'] = "Erro ao excluir usuario!";

// Redireciona de volta ao formulário de login
header("Location: ../view/ger-usuarios.php");
exit;

?>