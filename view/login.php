<?php 
require_once 'header.php';
require_once '../proc/funcBD.php';
session_start();
$erro_login = isset($_SESSION['erro_login']) ? $_SESSION['erro_login'] : "";
unset($_SESSION['erro_login']);
?>
<main class="d-flex flex-column justify-content-center align-items-center border-bottom conteudo py-2">
    <form class="d-flex flex-column justify-content-center" action="../proc/procLogin.php" method="POST">
        <div class="mb-3">
            <select class="form-select" aria-label="Usuarios" id="selectedUser" name="selectedUser">
                <?php 
                    $listaUsuarios = listarUsuarios();
                    while ($usuarios = mysqli_fetch_assoc($listaUsuarios)) {
                        echo "<option value=\"" . $usuarios["idUser"] . "\">" . $usuarios["nomeUser"] . "</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="senhaUser" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senhaUser" name="senhaUser" placeholder="Digite sua senha">
        </div>
        <button class="btn btn-primary" type="submit">Entrar</button>
    </form>
    <?php
    if($erro_login != ""){
        echo '<p class="py-3 mensagem-temporaria">'. $erro_login .'</p>';
    }
    ?>    
</main>
<?php require_once 'footer.php'; ?>