<?php

include "../php/db.php";

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rotas</title>
    <link rel="stylesheet" href="../Css/style.css">
</head>
<body class="rotas-page">
<aside id="sidebar" class="sidebar">
    <ul>
    <li><a href="index.php"><img src="../imagem/casa.png" alt="casa">Início</a></li>
      <li><a href="pessoal.php"><img src="../imagem/msg.png" alt="msg"> Informações Pessoais</a></li>
      <li><a href="index.php"><img src="../imagem/front-of-bus.png" alt="bus2"> Rotas</a></li>
      <li><a href="rotas2.php"><img src="../imagem/bus.png" alt="bus"> Gestão de Rotas</a></li>
      <li><a href="horario.php"><img src="../imagem/lugar.png" alt="lugar"> Quadro de Horários</a></li>
      <li><a href="notific.php"><img src="../imagem/carta.png" alt="carta">Relatórios</a></li>
      <li><a href="buscar.php"><img src="../imagem/search (1).png" alt="search"> Buscar</a></li>
      <li><a href="capa.php"><img src="../imagem/sair.png" alt="search"> Sair</a></li>
    </ul>
  </aside>


  <nav>
    <div class="flex">
      <img src="../imagem/menu.png" alt="logo-menu" id="menu-button" />

      <div class="LOGO1">
        <img src="../imagem/logo1.JPG" alt="LOG" />
      </div>

    

      <div class="lupa">
        <img src="../imagem/search (1).png" alt="lupa" />
        <p class="subtexto">BUSCAR</p>
      </div>
    </div>
  </nav>

  <script src="../Js/script.js"></script>

   <div class="rotas">
    <p>ROTAS</p>
   </div>

   <div class="ferrorama">
    <img src="../imagem/Captura de tela 2025-05-26 105546.png" alt="ferrorama">
   </div>

   <div class="notificacoes">
        <div class="mensagem">
            <img src="../imagem/danger.png" alt="notificações">
            <p>Trem A está atrasado!</p>
        </div>
        
        <div class="mensagem">
            <img src="../imagem/warning.png" alt="notificações">
            <p>Trem B necessita de manutenção!</p>
        </div>
   
        <div class="mensagem">
            <img src="../imagem/warning (1).png" alt="notificações">
            <p>Trilho da ferrovia 1 para 2 está danificado!</p>
        </div>
   </div>

</body>
</html>