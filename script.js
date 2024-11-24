// script.js
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    if (localStorage.getItem('theme') === 'dark') {
        body.classList.remove('light-theme');
        body.classList.add('dark-theme');
    }

    // Alterar o tema ao clicar no botão
    themeToggle.addEventListener('click', function() {
        if (body.classList.contains('light-theme')) {
            body.classList.remove('light-theme');
            body.classList.add('dark-theme');
            localStorage.setItem('theme', 'dark'); 
        } else {
            body.classList.remove('dark-theme');
            body.classList.add('light-theme');
            localStorage.setItem('theme', 'light'); 
        }
    });

});

document.getElementById('registerForm').addEventListener('submit', function(event) {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;
    const phone = document.getElementById('phone').value;

    // Validação de nome de usuário
    if (username.length < 3) {
        alert("O nome de usuário deve ter pelo menos 3 caracteres.");
        event.preventDefault();
        return;
    }

    // Validação de email
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(email)) {
        alert("Por favor, insira um e-mail válido.");
        event.preventDefault();
        return;
    }

    // Validação de senha
    if (password.length < 6) {
        alert("A senha deve ter pelo menos 6 caracteres.");
        event.preventDefault();
        return;
    }

});


