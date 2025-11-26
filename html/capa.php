<?php
include "../php/db.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferrovia Futuro - Bem-vindo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg,rgb(255, 255, 255) 0%,rgb(55, 68, 240) 100%);
            overflow: hidden;
            position: relative;
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

        .rail-line {
            position: absolute;
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
            animation: moveLine 8s linear infinite;
        }

        .rail-line:nth-child(1) {
            top: 20%;
            width: 150%;
            animation-delay: 0s;
        }

        .rail-line:nth-child(2) {
            top: 40%;
            width: 150%;
            animation-delay: 2s;
        }

        .rail-line:nth-child(3) {
            top: 60%;
            width: 150%;
            animation-delay: 4s;
        }

        .rail-line:nth-child(4) {
            top: 80%;
            width: 150%;
            animation-delay: 6s;
        }

        @keyframes moveLine {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Partículas flutuantes */
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: float 6s infinite ease-in-out;
        }

        .particle:nth-child(5) {
            width: 8px;
            height: 8px;
            top: 15%;
            left: 10%;
            animation-delay: 0s;
        }

        .particle:nth-child(6) {
            width: 12px;
            height: 12px;
            top: 45%;
            left: 80%;
            animation-delay: 1.5s;
        }

        .particle:nth-child(7) {
            width: 6px;
            height: 6px;
            top: 75%;
            left: 20%;
            animation-delay: 3s;
        }

        .particle:nth-child(8) {
            width: 10px;
            height: 10px;
            top: 30%;
            left: 60%;
            animation-delay: 4.5s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-30px) translateX(20px);
                opacity: 0.8;
            }
        }

        /* Container principal */
        .container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Logo com efeito glassmorphism */
        .logo-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 40px 60px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 50px;
            animation: fadeInScale 1s ease-out;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .logo-container img {
            width: 300px;
            height: auto;
            display: block;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        /* Título principal */
        .main-title {
            font-size: 3.5em;
            font-weight: bold;
            color: white;
            text-align: center;
            margin-bottom: 15px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out 0.3s both;
            letter-spacing: 2px;
        }

        .subtitle {
            font-size: 1.4em;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            margin-bottom: 60px;
            animation: fadeInUp 1s ease-out 0.5s both;
            font-weight: 300;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Botão moderno */
        .cta-button {
            position: relative;
            background: white;
            color: #667eea;
            padding: 20px 60px;
            font-size: 1.4em;
            font-weight: bold;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: fadeInUp 1s ease-out 0.7s both;
            overflow: hidden;
            text-decoration: none;
            display: inline-block;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .cta-button:active {
            transform: translateY(-2px) scale(1.02);
        }

        /* Ícone no botão */
        .button-icon {
            display: inline-block;
            margin-left: 15px;
            transition: transform 0.3s ease;
        }

        .cta-button:hover .button-icon {
            transform: translateX(10px);
        }

        /* Footer com trem */
        .footer {
            position: fixed;
            bottom: 0;
            right: 0;
            padding: 30px;
            animation: slideInRight 1s ease-out 1s both;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .footer img {
            width: 250px;
            height: auto;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.3));
            opacity: 0.9;
        }

        /* Features em destaque */
        .features {
            display: flex;
            gap: 30px;
            margin-top: 50px;
            animation: fadeInUp 1s ease-out 0.9s both;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px 35px;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        .feature-item i {
            font-size: 2em;
            margin-bottom: 10px;
            display: block;
        }

        .feature-item h3 {
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .feature-item p {
            font-size: 0.9em;
            opacity: 0.8;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .main-title {
                font-size: 2.5em;
            }

            .subtitle {
                font-size: 1.1em;
            }

            .logo-container {
                padding: 30px 40px;
            }

            .logo-container img {
                width: 200px;
            }

            .cta-button {
                padding: 15px 40px;
                font-size: 1.2em;
            }

            .features {
                flex-direction: column;
                gap: 15px;
            }

            .footer img {
                width: 150px;
            }
        }

        @media (max-width: 480px) {
            .main-title {
                font-size: 2em;
            }

            .subtitle {
                font-size: 1em;
            }

            .logo-container img {
                width: 180px;
            }
        }
    </style>
</head>
<body>
    <!-- Animação de fundo -->
    <div class="background-animation">
        <div class="rail-line"></div>
        <div class="rail-line"></div>
        <div class="rail-line"></div>
        <div class="rail-line"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Container principal -->
    <div class="container">
        <!-- Logo -->
        <div class="logo-container">
            <img src="../imagem/logo1.JPG" alt="Ferrovia Futuro Logo">
        </div>

        <!-- Título -->
        <h1 class="main-title">FERROVIA FUTURO</h1>
        <p class="subtitle">Conectando destinos com eficiência e modernidade</p>

        <!-- Botão principal -->
        <a href="login.php" class="cta-button">
            Começar Agora
            <span class="button-icon">→</span>
        </a>

        <!-- Features -->
        <div class="features">
            <div class="feature-item">
                <span style="font-size: 2em;"></span>
                <h3>Rotas Inteligentes</h3>
                <p>Tecnologia de ponta</p>
            </div>
            <div class="feature-item">
                <span style="font-size: 2em;"></span>
                <h3>Alta Velocidade</h3>
                <p>Conexões rápidas</p>
            </div>
            <div class="feature-item">
                <span style="font-size: 2em;"></span>
                <h3>Precisão</h3>
                <p>Horários exatos</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
   
</body>
</html>