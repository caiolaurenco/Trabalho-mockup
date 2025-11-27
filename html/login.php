<?php
include "../php/db.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ferrovia Futuro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animação de fundo */
        .background-animation {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            overflow: hidden;
        }

        .floating-shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
        }

        .floating-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 80%;
            animation-delay: 2s;
        }

        .floating-shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
        }

        .floating-shape:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 70%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-50px) rotate(180deg);
                opacity: 0.6;
            }
        }

        /* Container do login */
        .login-container {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 50px 40px;
            max-width: 450px;
            width: 100%;
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Botão de voltar */
        .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .back-button i {
            color: #667eea;
            font-size: 20px;
        }

        /* Logo e cabeçalho */
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .avatar-container {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .avatar-container i {
            font-size: 60px;
            color: white;
        }

        .login-header h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .login-header p {
            color: #666;
            font-size: 15px;
        }

        /* Formulário */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .input-group {
            position: relative;
        }

        .input-group i.icon-left {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 18px;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .input-group input {
            width: 100%;
            padding: 18px 20px 18px 55px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 16px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-group input:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .input-group input:focus ~ i.icon-left {
            color: #764ba2;
        }

        .input-group input::placeholder {
            color: #aaa;
        }

        /* Toggle de senha */
        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            font-size: 18px;
            transition: color 0.3s ease;
            z-index: 10;
            pointer-events: auto;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        /* Esqueceu senha */
        .forgot-password {
            text-align: right;
            margin-top: -10px;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Botão de login */
        .login-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button i {
            margin-left: 10px;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: #999;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }

        .divider span {
            padding: 0 15px;
        }

        /* Registro */
        .register-link {
            text-align: center;
            color: #666;
            font-size: 15px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #764ba2;
        }

        /* Footer com logo */
        .login-footer {
            margin-top: 35px;
            text-align: center;
        }

        .login-footer img {
            width: 180px;
            height: auto;
            opacity: 0.9;
            filter: grayscale(20%);
        }

        /* Mensagem de erro/sucesso */
        .message {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.error {
            background: #fee;
            color: #c33;
            border-left: 4px solid #c33;
        }

        .message.success {
            background: #efe;
            color: #3c3;
            border-left: 4px solid #3c3;
        }

        /* Responsividade */
        @media (max-width: 480px) {
            .login-container {
                padding: 40px 30px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .avatar-container {
                width: 100px;
                height: 100px;
            }

            .avatar-container i {
                font-size: 50px;
            }

            .input-group input {
                padding: 16px 20px 16px 50px;
                font-size: 15px;
            }

            .login-button {
                padding: 16px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Animação de fundo -->
    <div class="background-animation">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>

    <!-- Container do Login -->
    <div class="login-container">
        <!-- Botão de voltar -->
        <a href="index.php" class="back-button" title="Voltar">
            <i class="fas fa-times"></i>
        </a>

        <!-- Cabeçalho -->
        <div class="login-header">
            <div class="avatar-container">
                <i class="fas fa-user"></i>
            </div>
            <h1>Bem-vindo</h1>
            <p>Faça login para continuar</p>
        </div>

        <!-- Mensagem de feedback -->
        <div id="message" class="message"></div>

        <!-- Formulário -->
        <form class="login-form" id="loginForm">
            <div class="input-group">
                <i class="fas fa-envelope icon-left"></i>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="E-mail" 
                    required
                    autocomplete="email"
                >
            </div>

            <div class="input-group password-field">
                <i class="fas fa-lock icon-left"></i>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Senha" 
                    required
                    autocomplete="current-password"
                >
                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
            </div>

            <div class="forgot-password">
                <a href="#" id="forgotLink">Esqueceu sua senha?</a>
            </div>

            <button type="submit" class="login-button">
                Entrar
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="divider">
            <span>OU</span>
        </div>

        <div class="register-link">
            Não tem uma conta? <a href="#" id="registerLink">Cadastre-se</a>
        </div>

        <!-- Footer -->
        <div class="login-footer">
            <img src="../imagem/logo1.JPG" alt="Ferrovia Futuro">
        </div>
    </div>

    <script>
        // Toggle de visualização de senha
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Validação do formulário
        const loginForm = document.getElementById('loginForm');
        const messageDiv = document.getElementById('message');

        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            // Validação básica
            if (!email || !password) {
                showMessage('Por favor, preencha todos os campos.', 'error');
                return;
            }

            if (!isValidEmail(email)) {
                showMessage('Por favor, insira um e-mail válido.', 'error');
                return;
            }

            if (password.length < 4) {
                showMessage('A senha deve ter no mínimo 4 caracteres.', 'error');
                return;
            }

            // Enviar formulário via fetch
            const formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);

            fetch('../php/autenticarusuario.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Login realizado com sucesso! Redirecionando...', 'success');
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 1500);
                } else {
                    showMessage(data.message || 'Erro ao fazer login.', 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showMessage('Erro ao conectar com o servidor.', 'error');
            });
        });

        // Função para validar e-mail
        function isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }

        // Função para exibir mensagens
        function showMessage(text, type) {
            messageDiv.textContent = text;
            messageDiv.className = 'message ' + type;
            messageDiv.style.display = 'block';

            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 5000);
        }

        // Links de ação
        document.getElementById('forgotLink').addEventListener('click', function(e) {
            e.preventDefault();
            showMessage('Funcionalidade em desenvolvimento.', 'error');
        });

        document.getElementById('registerLink').addEventListener('click', function(e) {
            e.preventDefault();
            showMessage('No momento somente administradores podem criar novos usuários.', 'error');
        });

        // Animação de foco nos inputs
        const inputs = document.querySelectorAll('.input-group input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                const icon = this.parentElement.querySelector('i.icon-left');
                if (icon) {
                    icon.style.transform = 'translateY(-50%) scale(1.2)';
                }
            });

            input.addEventListener('blur', function() {
                const icon = this.parentElement.querySelector('i.icon-left');
                if (icon) {
                    icon.style.transform = 'translateY(-50%) scale(1)';
                }
            });
        });

document.addEventListener('DOMContentLoaded', function() {
    const logo = document.querySelector('nav .LOGO1 img');
    
    if (logo) {
        logo.style.cursor = 'pointer';
        
        logo.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.08)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        logo.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
        
        logo.addEventListener('click', function() {
            window.location.href = 'index.php';
        });

        logo.setAttribute('tabindex', '0');
        logo.setAttribute('role', 'button');
        logo.setAttribute('aria-label', 'Voltar para página inicial');
        
        logo.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                window.location.href = 'index.php';
            }
        });
    }
    
    const logoContainer = document.querySelector('nav .LOGO1');
    
    if (logoContainer && !logoContainer.querySelector('a')) {
        logoContainer.style.cursor = 'pointer';
        
        logoContainer.addEventListener('click', function() {
            window.location.href = 'index.php';
        });
    }
});

function tornarLogoClicavel() {
    const logo = document.querySelector('nav .LOGO1 img');
    
    if (logo) {
        logo.style.cursor = 'pointer';
        logo.onclick = function() {
            window.location.href = 'index.php';
        };
    }
}

    </script>
</body>
</html>