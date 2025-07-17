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
    $sql = "SELECT nomeUser, adminUser, acessosUser FROM usuarios WHERE idUser = '$idUser' AND senhaUser = '$senhaUser'";
    return mysqli_query($conexao, $sql);
}

#funcao atualiza acessos

function atualizaAcessos($idUser, $acessosUser) {

    $conexao = conectarBD();
    $sql = "UPDATE usuarios SET
            acessosUser = '$acessosUser'
            WHERE idUser = $idUser";
    mysqli_query($conexao, $sql);
}

#funcoes usuarios

// lista os usuarios na pagina de gerenciamento de usuarios / admin
function listarUsuarios() {

    $conexao = conectarBD();
    $sql = "SELECT * FROM usuarios ORDER BY nomeUser";
    return mysqli_query($conexao, $sql);
}

// mostra as informacoes do usuario na pagina de perfil do usuario
function infoUsuario($nomeUser) {

    $conexao = conectarBD();
    $sql = "SELECT * from usuarios WHERE nomeUser = '$nomeUser' LIMIT 1";
    return mysqli_query($conexao, $sql);
}

//cadastra o usuario na pagina de gerenciamento de usuarios / admin
function cadastrarUsuario($nomeUser, $sobrenomeUser, $emailUser, $adminUser) {

    $conexao = conectarBD();
    $sql = "INSERT INTO usuarios (nomeUser, sobrenomeUser, emailUser, senhaUser, tokenUser, adminUser, acessosUser)
            VALUES ('$nomeUser','$sobrenomeUser','$emailUser','123','token','$adminUser','0')";
    mysqli_query($conexao, $sql);
}

//altera o usuario na pagina de gerenciamento de usuarios / admin
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

//altera a senha do usuario na pagina de gerenciamento de usuarios / admin
function alterarSenhaUsuario($idUser, $senhaUser) {

    $conexao = conectarBD();
    $sql = "UPDATE usuarios SET senhaUser = '$senhaUser' WHERE idUser = $idUser";
    mysqli_query($conexao, $sql);
}

//exclui o usuario na pagina de gerenciamento de usuarios / admin
function excluirUsuario($idUser) {

    $conexao = conectarBD();
    $sql = "DELETE FROM usuarios WHERE idUser = $idUser";
    mysqli_query($conexao, $sql);
}

?>