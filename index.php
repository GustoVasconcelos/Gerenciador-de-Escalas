<?php
if(isset($_SESSION['logado']))
{
    header('Location: view/sistema.php');
    exit;
}
header('Location: view/login.php');
exit;
?>