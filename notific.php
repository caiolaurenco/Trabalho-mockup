<?php

include "db.php";

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rotas</title>
    <link rel="stylesheet" href="style.css">

</head>

<body class="notific-page">

 <aside id="sidebar" class="sidebar">
    <ul>
      <li><a href="index.php"><img src="imagem/casa.png" alt="casa">Início</a></li>
      <li><a href="pessoal.php"><img src="imagem/msg.png" alt="msg"> Informações Pessoais</a></li>
      <li><a href="index.php"><img src="imagem/front-of-bus.png" alt="bus2"> Rotas</a></li>
      <li><a href="rotas2.hphptml"><img src="imagem/bus.png" alt="bus"> Gestão de Rotas</a></li>
      <li><a href="horario.php"><img src="imagem/lugar.png" alt="lugar"> Quadro de Horários</a></li>
      <li><a href="notific.php"><img src="imagem/carta.png" alt="carta">Relatórios</a></li>
      <li><a href="buscar.php"><img src="imagem/search (1).png" alt="search"> Buscar</a></li>
      <li><a href="capa.php"><img src="imagem/sair.png" alt="search"> Sair</a></li>
    </ul>
  </aside>

  
  <nav>
    <div class="flex">
      <img src="imagem/menu.png" alt="logo-menu" id="menu-button" />

      <div class="LOGO1">
        <img src="imagem/logo1.JPG" alt="LOG" />
      </div>

      <div class="bus1">
        <img src="imagem/bus.png" alt="bus1" />
        <p class="subtexto">MEU LOCAL</p>
      </div>

      <div class="bus2">
        <img src="imagem/front-of-bus.png" alt="bus2" />
        <p class="subtexto">LINHAS</p>
      </div>

      <div class="lupa">
        <img src="imagem/search (1).png" alt="lupa" />
        <p class="subtexto">BUSCAR</p>
      </div>
    </div>
  </nav>

  <script src="script.js"></script>
    <div id="conteudo">
        <div class="flex4">
            <img src="imagem/notification.png" alt="notificações">
            <p>Falta de trem na ferrovia Sul!</p>
        </div>
        <div class="flex4">
            <img src="imagem/notification.png" alt="notificações">
            <p>Trem falhou em rota!</p>
        </div>
        <div class="flex5">
            <img src="imagem/notification.png" alt="notificações">
            <p>Trem saiu da estação norte!</p>
        </div>
        <div class="flex5">
            <img src="imagem/notification.png" alt="notificações">
            <p>Manifestação sobre o valor da passagem!</p>
        </div>
        <div class="flex5">
            <img src="imagem/notification.png" alt="notificações">
            <p>Climatização precaria!</p>
        </div>
        <div class="flex5">
            <img src="imagem/notification.png" alt="notificações">
            <p>Segurança atualizada com sucesso!</p>
        </div>
        <div class="flex5">
            <img src="imagem/notification.png" alt="notificações">
            <p>Atraso na saida do trem leste!</p>
        </div>
    </div>

    <button class="next_bt1" onclick="substituirImagem()">
      <div class="flex6">
        <p class="botao">Marcar como lido</p>
        <img src="imagem/check-box.png" alt="correto">
      </div>
    </button>
    <button class="next_bt" onclick="removerElementos()">
      <div class="flex7">
        <p class="botao1">Apagar notificações</p>
        <img src="imagem/silent.png" alt="correto">
      </div>
    </button>



    </div>

    <body>