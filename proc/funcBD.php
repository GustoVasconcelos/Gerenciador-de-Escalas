<?php

function conectarBD(){

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

function realizarLogin($idUser, $senhaUser){

    $conexao = conectarBD();
    $sql = "SELECT nomeUser, adminUser FROM usuarios WHERE idUser = '$idUser' AND senhaUser = '$senhaUser'";
    return mysqli_query($conexao, $sql);
}

#funcoes usuarios

function listaUsuarios(){

    $conexao = conectarBD();
    $sql = "SELECT * FROM usuarios ORDER BY nomeUser";
    return mysqli_query($conexao, $sql);
}

?>