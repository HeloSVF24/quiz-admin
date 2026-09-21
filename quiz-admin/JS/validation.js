document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('quizForm');

    form.addEventListener('submit', (event) => {
        // Validação padrão do HTML5 / Bootstrap
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        form.classList.add('was-validated');
    }, false);
});