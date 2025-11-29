<?php
include "../php/db.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Ferroviário</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .header {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
        }

        .header img {
            width: 200px;
            height: auto;
            margin-bottom: 20px;
            filter: none;
        }

        .header h1 {
            font-size: 2em;
            margin-bottom: 10px;
            text-shadow: none;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .menu-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            max-width: 500px;
            width: 100%;
            padding: 20px;
        }

        .menu-item:nth-child(7),
        .menu-item:nth-child(8) {
            grid-column: 1 / -1;
            max-width: 250px;
            margin: 0 auto;
            width: 100%;
        }

        .menu-item {
            background: #e8e8e8;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-decoration: none;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 160px;
            position: relative;
            overflow: hidden;
        }

        .menu-item:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .menu-item img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
            object-fit: contain;
            transition: transform 0.3s ease;
            z-index: 2;
            position: relative;
        }

        .menu-item h3 {
            font-size: 1em;
            color: rgb(0, 0, 0);
            margin-top: 5px;
            line-height: 1.3;
            z-index: 2;
            position: relative;
            transition: transform 0.3s ease;
        }

        @media (max-width: 768px) {
            .menu-container {
                gap: 15px;
                max-width: 450px;
            }

            .header h1 {
                font-size: 1.8em;
            }

            .header img {
                width: 180px;
            }

            .menu-item {
                padding: 20px;
                min-height: 140px;
            }

            .menu-item img {
                width: 45px;
                height: 45px;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.5em;
            }

            .header p {
                font-size: 1em;
            }

            .header img {
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="../imagem/logo1.JPG" alt="Logo Sistema Ferroviário">
        <h1>Sistema Ferroviário</h1>
        <p>Gestão Completa de Operações</p>
    </div>

    <div class="menu-container">
        <a href="pessoal.php" class="menu-item">
            <img src="../imagem/msg.png" alt="Informações Pessoais">
            <h3>Informações<br>Pessoais</h3>
        </a>

        <a href="gerenciar_usuarios.php" class="menu-item">
            <img src="../imagem/msg.png" alt="Gerenciar Usuários">
            <h3>Gerenciar<br>Usuários</h3>
        </a>

        <a href="rotas2.php" class="menu-item">
            <img src="../imagem/front-of-bus.png" alt="Rotas">
            <h3>Rotas</h3>
        </a>

        <a href="rotas2.php" class="menu-item">
            <img src="../imagem/bus.png" alt="Gestão de Rotas">
            <h3>Gestão de<br>Rotas</h3>
        </a>

        <a href="horario.php" class="menu-item">
            <img src="../imagem/lugar.png" alt="Quadro de Horários">
            <h3>Quadro de<br>Horários</h3>
        </a>

        <a href="notific.php" class="menu-item">
            <img src="../imagem/carta.png" alt="Relatórios">
            <h3>Relatórios</h3>
        </a>

        <a href="buscar.php" class="menu-item">
            <img src="../imagem/search (1).png" alt="Buscar">
            <h3>Buscar</h3>
        </a>

        <a href="capa.php" class="menu-item">
            <img src="../imagem/sair.png" alt="Sair">
            <h3>Sair</h3>
        </a>
    </div>

    <script src="../Js/script.js"></script>
  
</body>
</html>