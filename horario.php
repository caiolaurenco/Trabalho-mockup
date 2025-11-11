<?php

include "db.php";

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rotas</title>
  </head>
  <body class="horario-page">
    <aside id="sidebar" class="sidebar">
      <ul>
        <li><a href="index.php"><img src="imagem/casa.png" alt="casa">Início</a></li>
        <li><a href="pessoal.php"><img src="imagem/msg.png" alt="msg"> Informações Pessoais</a></li>
        <li><a href="index.php"><img src="imagem/front-of-bus.png" alt="bus2"> Rotas</a></li>
        <li><a href="rotas2.php"><img src="imagem/bus.png" alt="bus"> Gestão de Rotas</a></li>
        <li><a href="horario.php"><img src="imagem/lugar.png" alt="lugar"> Quadro de Horários</a></li>
        <li><a href="notific.php"><img src="imagem/carta.png" alt="carta">Relatórios</a></li>
        <li><a href="buscar.php"><img src="imagem/search (1).png" alt="search"> Buscar</a></li>
        <li><a href="capa.php"><img src="imagem/search (1).png" alt="search"> Sair</a></li>
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
    
    <div class="top-bar">
      <input type="date" value="2025-04-08" class="data-input" />
      <select class="estacao-select">
        <option>Selecionar estação</option>
        <option>Estação Central</option>
        <option>Estação Norte</option>
        <option>Estação Sul</option>
      </select>
    </div>
    
    <div class="tabela-horarios">
      <div class="linha">
        <span class="hora">08:00</span>
        <span class="hora">08:04</span>
        <span class="hora">08:07</span>
      </div>
      <div class="linha">
        <span class="hora">08:11</span>
        <span class="hora">08:18</span>
        <span class="hora">08:27</span>
      </div>
      <div class="linha">
        <span class="hora">08:38</span>
        <span class="hora">08:52</span>
        <span class="hora">09:02</span>
      </div>
      <div class="linha">
        <span class="hora">09:09</span>
        <span class="hora">09:17</span>
        <span class="hora">09:28</span>
      </div>
      <div class="linha">
        <span class="hora">10:11</span>
        <span class="hora">10:23</span>
        <span class="hora">10:41</span>
      </div>
    </div>
    
    
    <link rel="stylesheet" href="style.css">
  </body>
  </html>