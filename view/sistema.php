<?php
session_start();
if(!isset($_SESSION['nomeUser']))
{
    header('Location: login.php');
    exit;
}
require_once 'header.php';
?>
<main class="d-flex justify-content-center align-items-center border-bottom conteudo py-2">
    Sistema
</main>
<?php require_once 'footer.php'; ?>