<?php

include "../php/db.php";

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buscar</title>
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

  <div class="container">
    <h2>Buscar Informações</h2>

    <form class="form-busca">
      <input type="text" placeholder="Digite o que deseja buscar..." required>
      <button type="submit">Buscar</button>
    </form>

    

</body>
</html>