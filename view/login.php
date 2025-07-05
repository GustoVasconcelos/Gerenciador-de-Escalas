<?php require_once 'header.php' ?>
<main class="d-flex justify-content-center align-items-center border-bottom conteudo py-2">
    <form class="d-flex flex-column justify-content-center" action="" method="post">
        <div class="mb-3">
            <label for="userNome" class="form-label">Login</label>
            <input type="text" class="form-control" id="userNome" placeholder="Digite seu usuário">
        </div>
        <div class="mb-3">
            <label for="userSenha" class="form-label">Senha</label>
            <input type="text" class="form-control" id="userSenha" placeholder="Digite sua senha">
        </div>
        <button class="btn btn-primary" type="button">Entrar</button>
    </form>
</main>
<?php require_once 'footer.php' ?>