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
    <div class="d-flex flex-column px-3 py-2 text-bg-dark w-100 h-25">
        <div class="d-flex justify-content-center align-items-center w-100 h-25">
            <h5 class="border-bottom px-2 py-1">Lista de Usuarios</h5>
        </div>
        <div class="py-4">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Email</th>
                        <th>Senha</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $listaUsuarios = listarUsuarios();
                        while ($usuario = mysqli_fetch_assoc($listaUsuarios)) {
                            //echo "<option value=\"" . $usuario["idUser"] . "\">" . $usuario["nomeUser"] . "</option>";
                            echo "<tr>";
                            echo "<th>" . $usuario["nomeUser"] . "</th>";
                            echo "<th>" . $usuario["sobrenomeUser"] . "</th>";
                            echo "<th>" . $usuario["emailUser"] . "</th>";
                            echo '<th><a class="btn btn-primary btn-sm" href="#">Alterar</a></th>';
                            echo "<th>" . ($usuario["adminUser"] == 1 ? "Sim" : "Nao") . "</th>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            <a class="btn btn-primary" href="adduser.php">Adicionar Usuario</a>
        </div>
    </div>
</main>
<?php require_once 'footer.php'; ?>