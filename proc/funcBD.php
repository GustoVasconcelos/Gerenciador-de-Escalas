<?php

function conectarBD() {

    $host       = "localhost";
    $user       = "root";
    $pass       = "";
    $database   = "siem";

    $conexao = mysqli_connect($host, $user, $pass, $database);
 
    if (!$conexao) {
        die('Erro ao conectar ao banco: ' . mysqli_connect_error());
    }
 
    return $conexao;
}

#funcao autenticacao

function realizarLogin($idUser, $senhaUser) {

    $conexao = conectarBD();
    $sql = "SELECT nomeUser, adminUser FROM usuarios WHERE idUser = '$idUser' AND senhaUser = '$senhaUser'";
    return mysqli_query($conexao, $sql);
}

#funcoes usuarios

function listarUsuarios() {

    $conexao = conectarBD();
    $sql = "SELECT * FROM usuarios ORDER BY nomeUser";
    return mysqli_query($conexao, $sql);
}

function cadastrarUsuario($nomeUser, $sobrenomeUser, $emailUser, $adminUser) {

    $conexao = conectarBD();
    $sql = "INSERT INTO usuarios (nomeUser, sobrenomeUser, emailUser, senhaUser, tokenUser, adminUser)
            VALUES ('$nomeUser','$sobrenomeUser','$emailUser','123','token','$adminUser')";
    mysqli_query($conexao, $sql);
}

function alterarUsuario($idUser, $nomeUser, $sobrenomeUser, $emailUser, $adminUser) {

    $conexao = conectarBD();
    $sql = "UPDATE usuarios SET
            nomeUser = '$nomeUser',
            sobrenomeUser = '$sobrenomeUser',
            emailUser = '$emailUser',
            adminUser = $adminUser
            WHERE idUser = $idUser";
    mysqli_query($conexao, $sql);
}

function alterarSenhaUsuario($idUser, $senhaUser) {

    $conexao = conectarBD();
    $sql = "UPDATE usuarios SET senhaUser = '$senhaUser' WHERE idUser = $idUser";
    mysqli_query($conexao, $sql);
}

function excluirUsuario($idUser) {

    $conexao = conectarBD();
    $sql = "DELETE FROM usuarios WHERE idUser = $idUser";
    mysqli_query($conexao, $sql);
}

?>