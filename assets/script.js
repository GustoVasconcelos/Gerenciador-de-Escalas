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

