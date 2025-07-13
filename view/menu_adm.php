<?php
session_start();
if ($_SESSION['adminUser'] != 1) {
    header('Location: index.php');
    exit;
}
$page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
?>
    <div class="d-flex flex-column flex-shrink-0 px-3 py-2 text-bg-dark" style="width: 210px;">
        <span class="text-center">Menu</span>
        <hr>
        <ul class="nav nav-pills flex-colums align-items-center mb-auto">
            <li class="nav-item">
                <a href="ger-usuarios.php" class="nav-link <?= $page == 'ger-usuarios.php' ? 'active':''; ?>">Gerenciar Usuarios</a>
            </li>
            <li class="nav-item">
                <a href="config-email.php" class="nav-link <?= $page == 'config-email.php' ? 'active':''; ?>">Configurar Email</a>
            </li>
        </ul>
    </div>  