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
  <style>
    .search-container {
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
    }

    .search-header {
      text-align: center;
      margin-bottom: 40px;
    }

    .search-header h2 {
      color: #003366;
      font-size: 32px;
      margin-bottom: 10px;
    }

    .search-header p {
      color: #666;
      font-size: 16px;
    }

    .search-box {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .search-input-group {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .search-input-group input {
      flex: 1;
      padding: 15px 20px;
      border: 2px solid #ddd;
      border-radius: 10px;
      font-size: 16px;
      outline: none;
      transition: border-color 0.3s;
    }

    .search-input-group input:focus {
      border-color: #003366;
    }

    .search-input-group button {
      padding: 15px 30px;
      background: #003366;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }

    .search-input-group button:hover {
      background: #00509e;
    }

    .quick-links {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
      margin-top: 30px;
    }

    .quick-link-card {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s;
      border: 2px solid transparent;
      text-decoration: none;
      color: #333;
    }

    .quick-link-card:hover {
      background: #003366;
      color: white;
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 51, 102, 0.3);
    }

    .quick-link-card img {
      width: 40px;
      height: 40px;
      margin-bottom: 10px;
      filter: grayscale(0);
      transition: filter 0.3s;
    }

    .quick-link-card:hover img {
      filter: brightness(0) invert(1);
    }

    .quick-link-card h3 {
      font-size: 16px;
      margin: 0;
    }

    .results-container {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      display: none;
    }

    .results-container.show {
      display: block;
    }

    .result-item {
      padding: 20px;
      border-bottom: 1px solid #eee;
      cursor: pointer;
      transition: background 0.3s;
    }

    .result-item:hover {
      background: #f8f9fa;
    }

    .result-item:last-child {
      border-bottom: none;
    }

    .result-item h4 {
      color: #003366;
      margin-bottom: 8px;
      font-size: 18px;
    }

    .result-item p {
      color: #666;
      margin: 0;
      font-size: 14px;
    }

    .no-results {
      text-align: center;
      padding: 40px;
      color: #999;
    }

    .no-results img {
      width: 80px;
      opacity: 0.3;
      margin-bottom: 20px;
    }
  </style>
</head>
<body class="buscar-page">
  <aside id="sidebar" class="sidebar">
    <ul>
      <li><a href="index.php"><img src="../imagem/casa.png" alt="casa">Início</a></li>
      <li><a href="pessoal.php"><img src="../imagem/msg.png" alt="msg"> Informações Pessoais</a></li>
      <li><a href="index.php"><img src="../imagem/front-of-bus.png" alt="bus2"> Rotas</a></li>
      <li><a href="rotas2.php"><img src="../imagem/bus.png" alt="bus"> Gestão de Rotas</a></li>
      <li><a href="horario.php"><img src="../imagem/lugar.png" alt="lugar"> Quadro de Horários</a></li>
      <li><a href="notific.php"><img src="../imagem/carta.png" alt="carta">Relatórios</a></li>
      <li><a href="buscar.php"><img src="../imagem/search (1).png" alt="search"> Buscar</a></li>
      <li><a href="capa.php"><img src="../imagem/sair.png" alt="sair"> Sair</a></li>
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

  <div class="search-container">
    <div class="search-header">
      <h2>Buscar no Sistema</h2>
      <p>Digite o que você procura ou escolha um acesso rápido abaixo</p>
    </div>

    <div class="search-box">
      <form class="search-input-group" id="searchForm">
        <input 
          type="text" 
          id="searchInput" 
          placeholder="Digite: rotas, horários, relatórios, usuários..." 
          autocomplete="off"
        >
        <button type="submit">Buscar</button>
      </form>

      <div class="quick-links">
        <a href="rotas2.php" class="quick-link-card">
          <img src="../imagem/bus.png" alt="rotas">
          <h3>Gestão de Rotas</h3>
        </a>
        <a href="horario.php" class="quick-link-card">
          <img src="../imagem/lugar.png" alt="horários">
          <h3>Horários</h3>
        </a>
        <a href="notific.php" class="quick-link-card">
          <img src="../imagem/carta.png" alt="relatórios">
          <h3>Relatórios</h3>
        </a>
        <a href="pessoal.php" class="quick-link-card">
          <img src="../imagem/msg.png" alt="usuários">
          <h3>Usuários</h3>
        </a>
      </div>
    </div>

    <div class="results-container" id="resultsContainer">
      <h3>Resultados da Busca</h3>
      <div id="resultsContent"></div>
    </div>
  </div>

  <script src="../Js/script.js"></script>
  <script>

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

    

    const searchData = [
      { title: 'Gestão de Rotas', description: 'Visualize e gerencie todas as rotas do sistema ferroviário', keywords: ['rota', 'rotas', 'gestao', 'ferrovia', 'trem', 'linha'], page: 'rotas2.php' },
      { title: 'Quadro de Horários', description: 'Consulte horários de partida e chegada dos trens', keywords: ['horario', 'horarios', 'hora', 'partida', 'chegada', 'tempo'], page: 'horario.php' },
      { title: 'Relatórios e Notificações', description: 'Visualize relatórios e notificações do sistema', keywords: ['relatorio', 'relatorios', 'notificacao', 'notificacoes', 'alerta', 'aviso'], page: 'notific.php' },
      { title: 'Informações Pessoais', description: 'Gerencie cadastro de usuários e informações pessoais', keywords: ['usuario', 'usuarios', 'pessoal', 'cadastro', 'perfil', 'conta'], page: 'pessoal.php' },
      { title: 'Página Inicial', description: 'Voltar para a página principal do sistema', keywords: ['inicio', 'home', 'principal', 'menu'], page: 'index.php' },
    ];

    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const resultsContainer = document.getElementById('resultsContainer');
    const resultsContent = document.getElementById('resultsContent');


    function normalizeText(text) {
      return text.toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '');
    }

   
    function performSearch(query) {
      const normalizedQuery = normalizeText(query.trim());
      
      if (normalizedQuery.length < 2) {
        resultsContainer.classList.remove('show');
        return;
      }

      const results = searchData.filter(item => {
        const titleMatch = normalizeText(item.title).includes(normalizedQuery);
        const descMatch = normalizeText(item.description).includes(normalizedQuery);
        const keywordMatch = item.keywords.some(keyword => 
          normalizeText(keyword).includes(normalizedQuery)
        );
        return titleMatch || descMatch || keywordMatch;
      });

      displayResults(results);
    }

  
    function displayResults(results) {
      resultsContainer.classList.add('show');

      if (results.length === 0) {
        resultsContent.innerHTML = `
          <div class="no-results">
            <img src="../imagem/search (1).png" alt="sem resultados">
            <h4>Nenhum resultado encontrado</h4>
            <p>Tente buscar por: rotas, horários, relatórios ou usuários</p>
          </div>
        `;
        return;
      }

      resultsContent.innerHTML = results.map(result => `
        <div class="result-item" onclick="window.location.href='${result.page}'">
          <h4>${result.title}</h4>
          <p>${result.description}</p>
        </div>
      `).join('');
    }

    
    searchForm.addEventListener('submit', function(e) {
      e.preventDefault();
      performSearch(searchInput.value);
    });

    
    searchInput.addEventListener('input', function() {
      performSearch(this.value);
    });

    
    document.addEventListener('click', function(e) {
      if (!resultsContainer.contains(e.target) && 
          !searchInput.contains(e.target) && 
          !searchForm.contains(e.target)) {
        resultsContainer.classList.remove('show');
      }
    });

    
    searchInput.addEventListener('focus', function() {
      if (this.value.trim().length >= 2) {
        resultsContainer.classList.add('show');
      }
    });
  </script>
</body>
</html>