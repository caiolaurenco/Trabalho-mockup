<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style3.css">
</head>

<body>
    <aside id="sidebar" class="sidebar">
    <ul>
      <li><a href="index.html"><img src="imagem/casa.png" alt="casa">Início</a></li>
      <li><a href="pessoal.html"><img src="imagem/msg.png" alt="msg"> Informações Pessoais</a></li>
      <li><a href="index.html"><img src="imagem/front-of-bus.png" alt="bus2"> Rotas</a></li>
      <li><a href="rotas2.html"><img src="imagem/bus.png" alt="bus"> Gestão de Rotas</a></li>
      <li><a href="horario.html"><img src="imagem/lugar.png" alt="lugar"> Quadro de Horários</a></li>
      <li><a href="notific.html"><img src="imagem/carta.png" alt="carta">Relatórios</a></li>
      <li><a href="buscar.html"><img src="imagem/search (1).png" alt="search"> Buscar</a></li>
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

    <div class="conteiner">
        
        <label id="texto">Acompanhe seu trem <br> em tempo real
        </label>
        <label id="texto1">CLIQUE AQUI PARA ACESSAR
        </label>
    </div>

    <div class="menu">
        <h2 class="titulo_menu">ROTAS</h2>
        <br>
        <input type="partida" id="partida1" placeholder="PONTO DE PARTIDA">
        <BR>
        <BR>
        <input type="destino" id="destino1" placeholder="Destino">
        <BR>
        <BR>
        <input type="data" id="data1" placeholder="Hoje - 26/05">
        <BR>
        <BR>
        <br>
        <input type="partida_chegada" id="pc1" placeholder="Partida">
        <input type="hora" id="hora1" placeholder="09:20">
        <BR>
        <BR>
        <input type="bucar" id="buscar1">
        <div class="busc">
        <input type="bucar" id="buscar2"> <p class="rotasgo">BUSCAR ROTAS </p>
        </div>
    </div>


    </div>

</html>