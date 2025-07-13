<?php
require_once '../proc/funcBD.php';
session_start();
if ($_SESSION['adminUser'] != 1) {
    header('Location: index.php');
    exit;
}
$msg_cadastro = isset($_SESSION['msg_cadastro']) ? $_SESSION['msg_cadastro'] : "";
unset($_SESSION['msg_cadastro']);
require_once 'header.php';
?>
    <main class="d-flex border-bottom conteudo py-2">
        <?php require_once 'menu_adm.php'; ?>
        <form action="../proc/procAddUser.php" method="post" class="" id="form-add-user">
            <fieldset>
                <legend class="text-center">Adicionar Usuario</legend>
                <div class="mb-3 row">
                    <label for="nomeUser" class="col-sm-2 col-form-label">Nome</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nomeUser" id="nomeUser" placeholder="Nome">
                        </div>
                </div>
                <div class="mb-3 row">
                    <label for="sobrenomeUser" class="col-sm-2 col-form-label">Sobrenome</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sobrenomeUser" id="sobrenomeUser" placeholder="Sobrenome">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="emailUser" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="emailUser" id="emailUser" placeholder="Email">
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <label class="form-check-label" for="checkAdm">
                        Admin
                    </label>
                    <input class="form-check-input" type="checkbox" value="" name="checkAdm" id="checkAdm">
                </div>
                <button class="btn btn-primary" type="submit">Adicionar</button>
            </fieldset>
        </form>
    </main>
<?php require_once 'footer.php'; ?>