document.addEventListener('DOMContentLoaded', function() {
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
});

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
    const modalBodyInput = altSenhaUserModal.querySelector('.modal-body form')

    modalTitle.textContent = `Alterar Senha - ${nomeuser}`
    modalBodyInput.id = `form-user-${iduser}`
    document.getElementById('btAltSenhaUser').setAttribute(`form`, `form-user-${iduser}`)
  })
}

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
    modalBodyInput.id = `form-user-${iduser}`
    document.getElementById('btAlterarUser').setAttribute(`form`, `form-user-${iduser}`)
    document.getElementById('altNomeUser').setAttribute(`value`, `${nomeuser}`)
    document.getElementById('altSobrenomeUser').setAttribute(`value`, `${sobrenomeuser}`)
    document.getElementById('altEmailUser').setAttribute(`value`, `${emailuser}`)
    document.getElementById('altCheckAdm').checked = !!adminuser && adminuser != 0 && adminuser != '0';
  })
}

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

    modalTitle.textContent = `Excluir Usuario - ${nomeuser}`
    modalBodyInput.id = `form-user-${iduser}`
    document.getElementById('btExcluiUser').setAttribute(`form`, `form-user-${iduser}`)
  })
}