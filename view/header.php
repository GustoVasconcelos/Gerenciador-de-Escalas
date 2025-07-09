<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Sistema Interno de Escalas do Master</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body>
    <header class="d-flex justify-content-md-between px-5 align-items-center border-bottom">
        <div class="d-flex justify-content-center py-3 align-items-center">
            <img src="../assets/img/logotipo-band.webp" alt="">
            <span class="px-2">SIEM - Sistema Interno de Escalas do Master</span>
        </div class="d-flex justify-content-md-end py-3 align-items-center">
        <div>
            <?php if(isset($_SESSION['nomeUser'])): ?>
            <a class="btn btn-primary " href="logout.php">Sair</a>
            <?php endif ?>
        </div>
    </header>
    <?php if(isset($_SESSION['nomeUser'])): ?>
    <nav class="d-flex justify-content-center py-2 border-bottom">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Escalas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Relatórios</a>
            </li>
            <?php if(isset($_SESSION['adminUser'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="#">Admin</a>
            </li>
            <?php endif ?>
        </ul>
    </nav>
    <?php endif ?>