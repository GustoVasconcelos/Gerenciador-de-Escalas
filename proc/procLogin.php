<?php

require_once '../proc/funcBD.php';
session_start();

// Verifica se email e senha foram enviados
if (!empty($_POST['selectedUser']) && !empty($_POST['senhaUser'])) {
    $idUser = $_POST['selectedUser'];
    $senhaUser = $_POST['senhaUser'];

    // Proteção contra SQL Injection
    $conexao = conectarBD();
    $senhaEsc = mysqli_real_escape_string($conexao, $senhaUser);

    // Tenta logar
    $resultado = realizarLogin($idUser, $senhaEsc);
    if ($resultado && $resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        
        // Grava na sessão apenas os dados necessários
        $_SESSION['nomeUser']      = $usuario['nomeUser'];
        $_SESSION['adminUser']  = (int) $usuario['adminUser'];

        header("Location: ../view/index.php");
        exit;
    } else {
        // Credenciais inválidas
        $_SESSION['erro_login'] = "Senha inválida";
    }
}

// Redireciona de volta ao formulário de login
header("Location: ../view/login.php");
exit;

?>