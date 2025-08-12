<?php
session_start();
require_once '../proc/funcBD.php';

if(!isset($_SESSION['nomeUser']))
{
    header('Location: login.php');
    exit;
}

// pega a lista dos usuarios
$listaUsuarios = listarUsuarios();
$todosUsuarios = [];
while ($usuarios = mysqli_fetch_assoc($listaUsuarios)) {
    $todosUsuarios[] = $usuarios;
}

require_once 'header.php';
?>
<main class="d-flex justify-content-center align-items-center border-bottom conteudo py-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Criar Nova Escala</h5>
                    </div>
                    <div class="card-body">
                        <form id="formEscala" method="post" action="../proc/procNovaEscala.php">
                            <!-- Período da Escala -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="dataInicial" class="form-label">Data Inicial</label>
                                    <input type="date" class="form-control" id="dataInicial" name="dataInicial" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="dataFinal" class="form-label">Data Final</label>
                                    <input type="date" class="form-control" id="dataFinal" name="dataFinal" required>
                                </div>
                            </div>
                            
                            <!-- Funcionários de Férias -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="temFerias" name="temFerias">
                                    <label class="form-check-label" for="temFerias">
                                        Algum funcionário está de férias neste período?
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Seleção de Funcionários (aparece apenas se temFerias estiver marcado) -->
                            <div class="mb-3" id="funcionariosFeriasContainer" style="display: none;">
                                <label for="funcionariosFerias" class="form-label">Selecione o funcionário de férias</label>
                                <select class="form-select" id="funcionariosFerias" name="selectTemFerias">
                                    <?php foreach ($todosUsuarios as $usuario) {
                                        echo "<option value=\"" . $usuario["idUser"] . "\">" . $usuario["nomeUser"] . "</option>";
                                    }
                                    ?>
                                </select>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="dataInicial" class="form-label">Inicio das Férias</label>
                                        <input type="date" class="form-control" id="dtInicioFerias" name="dtInicioFerias">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dataFinal" class="form-label">Final das Férias</label>
                                        <input type="date" class="form-control" id="dtFinalFerias" name="dtFinalFerias">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botão de Submissão -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-calendar-plus"></i> Criar Escala
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once 'footer.php'; ?>