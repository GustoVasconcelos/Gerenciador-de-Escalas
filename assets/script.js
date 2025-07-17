document.addEventListener('DOMContentLoaded', function() {
    // Mensagem Temporarias
    mensagemTemporaria();

    // Validacao de Senha
    validarFormularioSenha();

    // Mostrar Senhas
    mostrarSenhas();
});

function mensagemTemporaria() {
  // Seleciona todas as mensagens com a classe 'mensagem-temporaria'
    const errorMessages = document.querySelectorAll('.mensagem-temporaria');
    
    errorMessages.forEach(message => {
        // Configura a transição (se ainda não estiver no CSS)
        message.style.transition = 'opacity 1s ease-out';
        
        setTimeout(function() {
            message.style.opacity = '0';
            
            // Remove após a animação completar
            message.addEventListener('transitionend', function() {
                message.remove();
            });
        }, 5000); // 5 segundos
    });
}

// usado para alterar a senha do usuario na pagina de admin
const altSenhaUserModal = document.getElementById('altSenhaUserModal')
if (altSenhaUserModal) {
  altSenhaUserModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const nomeuser = button.getAttribute('data-bs-nomeuser')
    const iduser = button.getAttribute('data-bs-iduser')

    // Update the modal's content.
    const modalTitle = altSenhaUserModal.querySelector('.modal-title')
    //const modalBodyInput = altSenhaUserModal.querySelector('.modal-body form')

    modalTitle.textContent = `Alterar Senha - ${nomeuser}`
    //modalBodyInput.id = `form-alt-pass-${iduser}`
    //document.getElementById('btAltSenhaUser').setAttribute(`form`, `form-alt-pass-${iduser}`)
    document.getElementById('alterarSenhaUserID').setAttribute(`value`, `${iduser}`)
  })
}

// usado para alterar os dados do usuario na pagina de admin
const alteraUserModal = document.getElementById('alteraUserModal')
if (alteraUserModal) {
  alteraUserModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const iduser = button.getAttribute('data-bs-iduser')
    const nomeuser = button.getAttribute('data-bs-nomeuser')
    const sobrenomeuser = button.getAttribute('data-bs-sobrenomeuser')
    const emailuser = button.getAttribute('data-bs-emailuser')
    const adminuser = button.getAttribute('data-bs-adminuser')

    // Update the modal's content.
    const modalTitle = alteraUserModal.querySelector('.modal-title')
    const modalBodyInput = alteraUserModal.querySelector('.modal-body form')

    modalTitle.textContent = `Alterar Usuario - ${nomeuser}`
    modalBodyInput.id = `form-alt-user-${iduser}`
    document.getElementById('btAlterarUser').setAttribute(`form`, `form-alt-user-${iduser}`)
    document.getElementById('alterarUserID').setAttribute(`value`, `${iduser}`)
    document.getElementById('altNomeUser').setAttribute(`value`, `${nomeuser}`)
    document.getElementById('altSobrenomeUser').setAttribute(`value`, `${sobrenomeuser}`)
    document.getElementById('altEmailUser').setAttribute(`value`, `${emailuser}`)
    document.getElementById('altCheckAdm').checked = !!adminuser && adminuser != 0 && adminuser != '0';
  })
}

// usado para excluir o usuario na pagina de admin
const excluiUserModal = document.getElementById('excluiUserModal')
if (excluiUserModal) {
  excluiUserModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const nomeuser = button.getAttribute('data-bs-nomeuser')
    const iduser = button.getAttribute('data-bs-iduser')

    // Update the modal's content.
    const modalTitle = excluiUserModal.querySelector('.modal-title')
    const modalBodyInput = excluiUserModal.querySelector('.modal-body form')
    const modalMessageText = excluiUserModal.querySelector('.modal-body p')

    modalTitle.textContent = `Excluir Usuario - ${nomeuser}`
    modalMessageText.textContent = `Deseja excluir o usuario ${nomeuser}?`
    modalBodyInput.id = `form-del-user-${iduser}`
    document.getElementById('btExcluiUser').setAttribute(`form`, `form-del-user-${iduser}`)
    document.getElementById('excluiUserID').setAttribute(`value`, `${iduser}`)
  })
}

//validacao de senha
function validarFormularioSenha() {
    const form = document.getElementById('formSenha');
    const senhaInput = document.getElementById('altSenhaUser1');
    const confirmacaoInput = document.getElementById('altSenhaUser2');
    const feedbackForca = document.getElementById('feedbackForca');
    const feedbackConfirmacao = document.getElementById('feedbackConfirmacao');
    const barraForca = document.getElementById('forcaSenha');
    const mensagemErro = document.getElementById('mensagemErro');

    // Validação em tempo real da força da senha
    senhaInput.addEventListener('input', function() {
        const senha = this.value;
        const forca = calcularForcaSenha(senha);
        
        atualizarFeedbackForca(forca, senha);
    });

    // Validação em tempo real da confirmação
    confirmacaoInput.addEventListener('input', function() {
        const senha1 = senhaInput.value;
        const senha2 = this.value;
        
        if (senha1 && senha2) {
            if (senha1 === senha2) {
                feedbackConfirmacao.textContent = '✓ As senhas coincidem';
                feedbackConfirmacao.className = 'form-text text-success';
            } else {
                feedbackConfirmacao.textContent = '✗ As senhas não coincidem';
                feedbackConfirmacao.className = 'form-text text-danger';
            }
        } else {
            feedbackConfirmacao.textContent = '';
        }
    });

    // Validação no submit
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const senha1 = senhaInput.value;
        const senha2 = confirmacaoInput.value;
        const forca = calcularForcaSenha(senha1);
        
        // Limpa mensagens anteriores
        mensagemErro.classList.add('d-none');
        
        // Validações
        if (!senha1 || !senha2) {
            mostrarErro('Por favor, preencha ambos os campos de senha.');
            return;
        }
        
        if (senha1 !== senha2) {
            mostrarErro('As senhas não coincidem. Por favor, digite senhas iguais nos dois campos.');
            return;
        }
        
        if (forca.nivel < 3) { // Pelo menos força média
            mostrarErro('A senha é muito fraca. ' + forca.mensagem);
            return;
        }
        
        // Se tudo estiver OK, envia o formulário
        this.submit();
    });

    // Funções auxiliares
    function calcularForcaSenha(senha) {
        let score = 0;
        let mensagem = '';
        
        // Critérios de força
        const temMinuscula = /[a-z]/.test(senha);
        const temMaiuscula = /[A-Z]/.test(senha);
        const temNumero = /[0-9]/.test(senha);
        const temEspecial = /[^a-zA-Z0-9]/.test(senha);
        const tamanhoOk = senha.length >= 8;
        
        // Pontuação
        if (temMinuscula) score++;
        if (temMaiuscula) score++;
        if (temNumero) score++;
        if (temEspecial) score++;
        if (tamanhoOk) score += 2;
        if (senha.length >= 12) score += 2;
        
        // Determinar nível de força
        let nivel;
        if (score >= 7) {
            nivel = 4; // Muito forte
            mensagem = 'Senha muito forte!';
        } else if (score >= 5) {
            nivel = 3; // Forte
            mensagem = 'Senha forte.';
        } else if (score >= 3) {
            nivel = 2; // Média
            mensagem = 'Senha média. Adicione mais caracteres ou tipos diferentes.';
        } else {
            nivel = 1; // Fraca
            mensagem = 'Senha fraca. Use letras maiúsculas, minúsculas, números e caracteres especiais.';
        }
        
        return { nivel, mensagem, score };
    }

    function atualizarFeedbackForca(forca, senha) {
        // Atualiza a barra de progresso
        const percentual = (forca.score / 9) * 100;
        barraForca.style.width = percentual + '%';
        
        // Atualiza a cor conforme a força
        if (forca.nivel === 1) {
            barraForca.className = 'progress-bar bg-danger';
        } else if (forca.nivel === 2) {
            barraForca.className = 'progress-bar bg-warning';
        } else if (forca.nivel === 3) {
            barraForca.className = 'progress-bar bg-info';
        } else {
            barraForca.className = 'progress-bar bg-success';
        }
        
        // Atualiza o texto de feedback
        if (senha.length === 0) {
            feedbackForca.textContent = '';
            barraForca.style.width = '0%';
        } else {
            feedbackForca.textContent = forca.mensagem;
            feedbackForca.className = forca.nivel < 3 
                ? 'form-text text-danger' 
                : 'form-text text-success';
        }
    }

    function mostrarErro(mensagem) {
        mensagemErro.textContent = mensagem;
        mensagemErro.classList.remove('d-none');
        
        // Rolagem suave para o erro
        mensagemErro.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
        // Remove a mensagem após 5 segundos
        setTimeout(() => {
            mensagemErro.style.opacity = '0';
            setTimeout(() => {
                mensagemErro.classList.add('d-none');
                mensagemErro.style.opacity = '1';
            }, 1000);
        }, 5000);
    }
};

function mostrarSenhas() {
    // Alternar visibilidade individual para cada campo
    document.getElementById('toggleSenha1').addEventListener('click', function() {
        const senhaInput = document.getElementById('altSenhaUser1');
        const icon = this.querySelector('i');
        
        if (senhaInput.type === 'password') {
            senhaInput.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            senhaInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
    
    document.getElementById('toggleSenha2').addEventListener('click', function() {
        const senhaInput = document.getElementById('altSenhaUser2');
        const icon = this.querySelector('i');
        
        if (senhaInput.type === 'password') {
            senhaInput.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            senhaInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
};