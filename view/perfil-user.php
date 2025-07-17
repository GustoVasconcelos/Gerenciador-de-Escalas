<?php
require_once '../proc/funcBD.php';
session_start();
if(!isset($_SESSION['nomeUser']))
{
    header('Location: login.php');
    exit;
}
$msg_cadastro = isset($_SESSION['msg_cadastro']) ? $_SESSION['msg_cadastro'] : "";
unset($_SESSION['msg_cadastro']);
require_once 'header.php';
?>
<main class="d-flex justify-content-center align-items-center border-bottom conteudo py-2">
    <?php
    $usuario_temp = $_SESSION['nomeUser'];
    $resultado = infoUsuario($usuario_temp);
    $usuario = $resultado->fetch_assoc();
    ?>
    <div class="d-flex flex-column justify-content-center">
        <div class="profile-container">
            <!-- Cabeçalho do perfil -->
            <div class="text-center">
                <?php
                if($msg_cadastro != ""){
                    echo '<p class="py-2 mensagem-temporaria alert alert-light" role="alert">'. $msg_cadastro .'</p>';
                }
            ?>
                <h3>Meu Perfil</h3>
                <p class="text-muted">Gerencie suas informações pessoais</p>
            </div>
            
            <!-- Campos do perfil -->
            <div class="profile-fields">
                <div class="profile-field">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="profNomeUser" value="<?php echo $usuario['nomeUser']; ?>" readonly>
                </div>
                
                <div class="profile-field">
                    <label for="sobrenome" class="form-label">Sobrenome</label>
                    <input type="text" class="form-control" id="profSobrenomeUser" value="<?php echo $usuario['sobrenomeUser']; ?>" readonly>
                </div>
                
                <div class="profile-field">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="profEmail" value="<?php echo $usuario['emailUser']; ?>" readonly>
                </div>
            </div>
            
            <!-- Botões de ação -->
            <div class="profile-actions">
                <button type="button" class="btn btn-primary" id="btn-alterar-dados"
                data-bs-toggle="modal" 
                data-bs-target="#alteraUserPerfilModal" 
                data-bs-iduser="<?php echo $usuario["idUser"]; ?>" 
                data-bs-nomeuser="<?php echo $usuario["nomeUser"]; ?>" 
                data-bs-sobrenomeuser="<?php echo $usuario["sobrenomeUser"]; ?>" 
                data-bs-emailuser="<?php echo $usuario["emailUser"]; ?>" 
                data-bs-adminuser="<?php echo $usuario["adminUser"]; ?>">
                    Alterar Dados
                </button>
                
                <button type="button" class="btn btn-outline-secondary" id="btn-alterar-senha"
                data-bs-toggle="modal" 
                data-bs-target="#altSenhaUserModal" 
                data-bs-iduser="<?php echo $usuario["idUser"]; ?>" 
                data-bs-nomeuser="<?php echo $usuario["nomeUser"]; ?>">
                    Alterar Senha
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="alteraUserPerfilModal" tabindex="-1" aria-labelledby="alteraUserModalLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="alteraUserModalLabel">Alterar Usuario</h1>
                </div>
                <div class="modal-body">
                    <form action="../proc/procUserUpd.php" method="POST" class="" id="form-alterar-user">
                        <input type="hidden" id="alterarUserID" name="alterarUserID" value="">
                        <input type="hidden" name="origem" value="perfil-user">
                        <input type="hidden" id="altAdminUser" name="altAdminUser" value="">
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="form-alterar-user" id="btAlterarUser" class="btn btn-primary">Salvar</button>
                </div>
            </div>
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
                        <input type="hidden" name="origem" value="perfil-user">
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


</main>
<?php require_once 'footer.php'; ?>