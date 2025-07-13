<?php
require_once '../proc/funcBD.php';
session_start();
if ($_SESSION['adminUser'] != 1) {
    header('Location: index.php');
    exit;
}
$page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
require_once 'header.php';
?>
<main class="d-flex flex-nowrap border-bottom conteudo py-2">
    <?php require_once 'menu_adm.php'; ?>
</main>
<?php require_once 'footer.php'; ?>