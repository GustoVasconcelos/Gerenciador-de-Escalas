<?php
require_once '../proc/funcBD.php';
session_start();
if ($_SESSION['adminUser'] != 1) {
    header('Location: index.php');
    exit;
}
$page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
$msg_cadastro = isset($_SESSION['msg_cadastro']) ? $_SESSION['msg_cadastro'] : "";
unset($_SESSION['msg_cadastro']);
require_once 'header.php';
?>
<main class="d-flex flex-nowrap border-bottom conteudo py-2">
    <?php require_once 'menu_adm.php'; ?>
    <div class="d-flex flex-column px-3 py-2 text-bg-dark w-100 h-25">
        <div class="d-flex flex-column justify-content-center align-items-center w-100 h-25">
            <h5 class="border-bottom px-2 py-1">Lista de Usuarios</h5>
            <?php
                if($msg_cadastro != ""){
                    echo '<p class="py-2 mensagem-temporaria alert alert-light" role="alert">'. $msg_cadastro .'</p>';
                }
            ?> 
        </div>
        <div class="py-4 table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Email</th>
                        <th>Senha</th>
                        <th>Admin</th>
                        <th>Alterar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $listaUsuarios = listarUsuarios();
                        while ($usuario = mysqli_fetch_assoc($listaUsuarios)) {
                            echo "<tr>";
                            echo "<th>" . $usuario["nomeUser"] . "</th>";
                            echo "<th>" . $usuario["sobrenomeUser"] . "</th>";
                            echo "<th>" . $usuario["emailUser"] . "</th>";
                            echo '<th><a class="btn btn-primary btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#altSenhaUserModal" 
                                data-bs-iduser="' . $usuario["idUser"] .'" 
                                data-bs-nomeuser="' . $usuario["nomeUser"] .'" 
                                href="#">Alterar</a></th>';
                            echo "<th>" . ($usuario["adminUser"] == 1 ? "Sim" : "Nao") . "</th>";
                            echo '<th><a class="btn btn-info btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#alteraUserModal" 
                                data-bs-iduser="' . $usuario["idUser"] .'" 
                                data-bs-nomeuser="' . $usuario["nomeUser"] .'" 
                                data-bs-sobrenomeuser="' . $usuario["sobrenomeUser"] .'" 
                                data-bs-emailuser="' . $usuario["emailUser"] .'" 
                                data-bs-adminuser="' . $usuario["adminUser"] .'" 
                                href="#">Alterar</a></th>';
                            echo '<th><a class="btn btn-danger btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#excluiUserModal" 
                                data-bs-iduser="' . $usuario["idUser"] .'" 
                                data-bs-nomeuser="' . $usuario["nomeUser"] .'"
                                href="#">Excluir</a></th>';
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cadastraUserModal">Adicionar Usuario</button>
        </div>
    </div>

    <div class="modal fade" id="altSenhaUserModal" tabindex="-1" aria-labelledby="altSenhaUserModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="altSenhaUserModalLabel">Alterar senha do</h1>
                </div>
                <div class="modal-body">
                    <form method="POST" action="../proc/procUserPass.php" id="formSenha">
                        <input type="hidden" id="alterarSenhaUserID" name="alterarSenhaUserID" value="">
                        <div class="mb-3">
                            <label for="altSenhaUser1" class="col-form-label">Nova senha:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="altSenhaUser1" id="altSenhaUser1" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleSenha1">
                                    <i class="bi bi-eye"></i> <!-- Ícone do Bootstrap Icons -->
                                </button>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div id="forcaSenha" class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small id="feedbackForca" class="form-text"></small>
                        </div>
                        <div class="mb-3">
                            <label for="altSenhaUser2" class="col-form-label">Confirmar nova senha:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="altSenhaUser2" id="altSenhaUser2" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleSenha2">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small id="feedbackConfirmacao" class="form-text"></small>
                        </div>
                        <div id="mensagemErro" class="alert alert-danger mt-3 d-none"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formSenha" id="btAltSenhaUser" class="btn btn-primary">Alterar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-sheet fade" id="excluiUserModal" tabindex="-1" aria-labelledby="excluiUserModalLabel" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="excluiUserModalLabel">Excluir Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Deseja excluir o usuario selecionado?</p>
                    <form action="../proc/procUserDel.php" method="POST">
                        <input type="hidden" id="excluiUserID" name="excluiUserID" value="">
                    </form>
                </div>
                <div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
                    <button type="submit" form="" id="btExcluiUser" class="btn btn-danger">Excluir</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="alteraUserModal" tabindex="-1" aria-labelledby="alteraUserModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="alteraUserModalLabel">Alterar Usuario</h1>
                </div>
                <div class="modal-body">
                    <form action="../proc/procUserUpd.php" method="POST" class="" id="form-alterar-user">
                        <input type="hidden" id="alterarUserID" name="alterarUserID" value="">
                        <div class="mb-3">                        
                            <label for="altNomeUser" class="col-sm-2 col-form-label">Nome</label>
                            <input type="text" class="form-control" name="altNomeUser" id="altNomeUser" placeholder="Digite o nome">
                        </div>
                        <div class="mb-3">
                            <label for="altSobrenomeUser" class="col-sm-2 col-form-label">Sobrenome</label>
                            <input type="text" class="form-control" name="altSobrenomeUser" id="altSobrenomeUser" placeholder="Digite o sobrenome">
                        </div>
                        <div class="mb-3">
                            <label for="altEmailUser" class="col-sm-2 col-form-label">Email</label>
                            <input type="email" class="form-control" name="altEmailUser" id="altEmailUser" placeholder="Digite o e-mail">
                        </div>
                        <div class="mb-3 form-check">
                            <label class="form-check-label" for="altCheckAdm">
                                <span data-bs-toggle="tooltip" title="Usuario Adiministrador?">Admin</span>
                            </label>
                            <input class="form-check-input" type="checkbox" value="" name="altCheckAdm" id="altCheckAdm">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="form-alterar-user" id="btAlterarUser" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cadastraUserModal" tabindex="-1" aria-labelledby="cadastraUserModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cadastraUserModalLabel">Adicionar Usuario</h1>
                </div>
                <div class="modal-body">
                    <form action="../proc/procUserAdd.php" method="POST" class="" id="form-add-user">
                        <div class="mb-3">                        
                            <label for="nomeUser" class="col-sm-2 col-form-label">Nome</label>
                            <input type="text" class="form-control" name="nomeUser" id="nomeUser" placeholder="Digite o nome">
                        </div>
                        <div class="mb-3">
                            <label for="sobrenomeUser" class="col-sm-2 col-form-label">Sobrenome</label>
                            <input type="text" class="form-control" name="sobrenomeUser" id="sobrenomeUser" placeholder="Digite o sobrenome">
                        </div>
                        <div class="mb-3">
                            <label for="emailUser" class="col-sm-2 col-form-label">Email</label>
                            <input type="email" class="form-control" name="emailUser" id="emailUser" placeholder="Digite o e-mail">
                        </div>
                        <div class="mb-3 form-check">
                            <label class="form-check-label" for="checkAdm">
                                <span data-bs-toggle="tooltip" title="Usuario Adiministrador?">Admin</span>
                            </label>
                            <input class="form-check-input" type="checkbox" value="" name="checkAdm" id="checkAdm">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="form-add-user" id="btCadastraUser" class="btn btn-primary">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once 'footer.php'; ?>