<?php
session_start();
require_once '../proc/funcBD.php';
require_once '../proc/funcoes.php';

if(!isset($_SESSION['nomeUser']))
{
    header('Location: login.php');
    exit;
}

// Recuperar dados da sessão
if (!isset($_SESSION['dadosEscala'])) {
    header('Location: escalas.php');
    exit();
}

$dados          = $_SESSION['dadosEscala'];
$dataInicial    = $dados['dataInicial'];
$dataFinal      = $dados['dataFinal'];
$periodo        = $dados['periodo'];
$temFerias      = $dados['temFerias'];
$funcFerias     = $dados['funcFerias'];

// Limpar a sessão após uso
//unset($_SESSION['dadosEscala']);

// pega a lista dos usuarios
$listaUsuarios = listarUsuarios();
$todosUsuarios = [];
while ($usuarios = mysqli_fetch_assoc($listaUsuarios)) {
    $todosUsuarios[] = $usuarios;
}

//determina a quantidade de turnos de trabalho de acordo com a ferias do funcionario selecionado
if($temFerias != 1)
    $turnosTrabalho = ['06:00 - 12:00','12:00 - 18:00','18:00 - 00:00','00:00 - 06:00'];
else
    $turnosTrabalho = ['06:00 - 14:00','14:00 - 22:00','22:00 - 06:00'];

require_once 'header.php';
?>
<main class="d-flex justify-content-center align-items-center border-bottom conteudo py-2">
    <div class="container m-2">
        <div class="row justify-content-center mb-3">
            <?php foreach($periodo as $data): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <?php $diaSemana = traduzirDiaSemana($data); ?>
                        <h5 class="mb-0 text-uppercase"><?php echo $data->format('d/m/Y') . " - " . $diaSemana; ?></h5>
                    </div>
                    <div class="card-body">
                        <form id="formEscala" method="post" action="processa_escala.php">
                            <!-- Período da Escala -->
                            <?php foreach($turnosTrabalho as $turnos): ?>
                            <div class="row mb-3">
                                <div class="col-md-6 d-flex align-items-center">
                                    <span class="fs-5"><?php echo $turnos ?></span>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="" id="">
                                        <?php foreach ($todosUsuarios as $usuario) {
                                            echo "<option value=\"" . $usuario["idUser"] . "\">" . $usuario["nomeUser"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <div class="row mb-1">
                                <div class="col-md-6 d-flex align-items-center justify-content-center">
                                    <span class="fs-5 text text-uppercase">folga</span>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="" id="">
                                        <?php foreach ($todosUsuarios as $usuario) {
                                            echo "<option value=\"" . $usuario["idUser"] . "\">" . $usuario["nomeUser"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php require_once 'footer.php'; ?>