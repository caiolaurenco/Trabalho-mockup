<?php
include "../php/db.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relatórios e Notificações</title>
  <link rel="stylesheet" href="../Css/style.css">
  <style>
    .notificacao-item {
      transition: all 0.3s ease;
      opacity: 1;
      transform: translateX(0);
    }

    .notificacao-item.removing {
      opacity: 0;
      transform: translateX(-100%);
      max-height: 0;
      margin-bottom: 0 !important;
      padding: 0 !important;
      overflow: hidden;
    }

    .notificacao-item.read {
      opacity: 0.6;
    }

    .sininho-badge {
      position: relative;
      display: inline-block;
    }

    .sininho-badge::after {
      content: '';
      position: absolute;
      top: -2px;
      right: -2px;
      width: 10px;
      height: 10px;
      background-color: #e74c3c;
      border-radius: 50%;
      border: 2px solid white;
      transition: opacity 0.3s ease;
    }

    .sininho-badge.no-badge::after {
      opacity: 0;
      display: none;
    }

    .contador-notificacoes {
      text-align: center;
      padding: 15px;
      background: #f8f9fa;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 16px;
      color: #333;
      font-weight: bold;
    }

    .contador-notificacoes span {
      color: #e74c3c;
      font-size: 20px;
    }

    .flex6, .flex7 {
      position: relative;
    }

    .mensagem-vazia {
      text-align: center;
      padding: 60px 20px;
      color: #999;
    }

    .mensagem-vazia img {
      width: 80px;
      opacity: 0.3;
      margin-bottom: 20px;
    }

    .mensagem-vazia h3 {
      color: #666;
      margin-bottom: 10px;
    }

    .mensagem-vazia p {
      color: #999;
    }
  </style>
</head>
<body class="notific-page">

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

  <div class="contador-notificacoes" id="contadorNotificacoes">
    Você tem <span id="numeroNotificacoes">7</span> notificações não lidas
  </div>

  <div id="conteudo">
    <div class="flex4 notificacao-item" data-id="1">
      <div class="sininho-badge">
        <img src="../imagem/notification.png" alt="notificações">
      </div>
      <p>Falta de trem na ferrovia Sul!</p>
    </div>

    <div class="flex4 notificacao-item" data-id="2">
      <div class="sininho-badge">
        <img src="../imagem/notification.png" alt="notificações">
      </div>
      <p>Trem falhou em rota!</p>
    </div>

    <div class="flex5 notificacao-item" data-id="3">
      <div class="sininho-badge">
        <img src="../imagem/notification.png" alt="notificações">
      </div>
      <p>Trem saiu da estação norte!</p>
    </div>

    <div class="flex5 notificacao-item" data-id="4">
      <div class="sininho-badge">
        <img src="../imagem/notification.png" alt="notificações">
      </div>
      <p>Manifestação sobre o valor da passagem!</p>
    </div>

    <div class="flex5 notificacao-item" data-id="5">
      <div class="sininho-badge">
        <img src="../imagem/notification.png" alt="notificações">
      </div>
      <p>Climatização precaria!</p>
    </div>

    <div class="flex5 notificacao-item" data-id="6">
      <div class="sininho-badge">
        <img src="../imagem/notification.png" alt="notificações">
      </div>
      <p>Segurança atualizada com sucesso!</p>
    </div>

    <div class="flex5 notificacao-item" data-id="7">
      <div class="sininho-badge">
        <img src="../imagem/notification.png" alt="notificações">
      </div>
      <p>Atraso na saida do trem leste!</p>
    </div>
  </div>

  <button class="next_bt1" onclick="marcarComoLido()">
    <div class="flex6">
      <p class="botao">Marcar como lido</p>
      <img src="../imagem/check-box.png" alt="correto">
    </div>
  </button>

  <button class="next_bt" id="toggleNotificBtn" onclick="toggleNotificacoes()">
    <div class="flex7">
      <p class="botao1" id="toggleText">Desativar notificações</p>
      <img src="../imagem/silent.png" alt="notificações" id="toggleIcon">
    </div>
  </button>

  <script src="../Js/script.js"></script>
  <script>
    let notificacoesAtivas = true;

    // Função para atualizar contador
    function atualizarContador() {
      const notificacoes = document.querySelectorAll('.notificacao-item:not(.removing)');
      const numero = notificacoes.length;
      const contador = document.getElementById('numeroNotificacoes');
      const contadorDiv = document.getElementById('contadorNotificacoes');
      
      contador.textContent = numero;
      
      if (numero === 0) {
        contadorDiv.style.display = 'none';
        mostrarMensagemVazia();
      } else {
        contadorDiv.style.display = 'block';
      }
    }

    // Função para mostrar mensagem quando não há notificações
    function mostrarMensagemVazia() {
      const conteudo = document.getElementById('conteudo');
      if (conteudo.children.length === 0) {
        conteudo.innerHTML = `
          <div class="mensagem-vazia">
            <img src="../imagem/notification.png" alt="sem notificações">
            <h3>Nenhuma notificação</h3>
            <p>Você está em dia com todas as notificações!</p>
          </div>
        `;
      }
    }

    // Função para marcar como lido (remove as notificações)
    function marcarComoLido() {
      const notificacoes = document.querySelectorAll('.notificacao-item:not(.removing)');
      
      if (notificacoes.length === 0) {
        alert('Não há notificações para marcar como lida.');
        return;
      }

      // Adiciona classe de remoção com delay escalonado
      notificacoes.forEach((notif, index) => {
        setTimeout(() => {
          // Remove o badge vermelho
          const badge = notif.querySelector('.sininho-badge');
          if (badge) {
            badge.classList.add('no-badge');
          }
          
          // Adiciona classe de remoção
          notif.classList.add('removing');
          
          // Remove do DOM após animação
          setTimeout(() => {
            notif.remove();
            atualizarContador();
          }, 300);
        }, index * 100); // Delay de 100ms entre cada notificação
      });
    }

    // Função para toggle de notificações
    function toggleNotificacoes() {
      const conteudo = document.getElementById('conteudo');
      const toggleText = document.getElementById('toggleText');
      const toggleIcon = document.getElementById('toggleIcon');

      if (notificacoesAtivas) {
        // Desativar notificações
        conteudo.style.display = 'none';
        toggleText.textContent = 'Ativar notificações';
        toggleIcon.src = '../imagem/notification.png';
        toggleIcon.alt = 'ativar';
        notificacoesAtivas = false;
        document.getElementById('contadorNotificacoes').style.display = 'none';
      } else {
        // Ativar notificações
        conteudo.style.display = 'block';
        toggleText.textContent = 'Desativar notificações';
        toggleIcon.src = '../imagem/silent.png';
        toggleIcon.alt = 'notificações';
        notificacoesAtivas = true;
        atualizarContador();
      }
    }

    // Adicionar funcionalidade de clique individual em cada notificação
    document.addEventListener('DOMContentLoaded', function() {
      const notificacoes = document.querySelectorAll('.notificacao-item');
      
      notificacoes.forEach(notif => {
        notif.addEventListener('click', function() {
          if (!this.classList.contains('removing')) {
            // Remove o badge vermelho
            const badge = this.querySelector('.sininho-badge');
            if (badge) {
              badge.classList.add('no-badge');
            }
            
            // Adiciona classe de remoção
            this.classList.add('removing');
            
            // Remove do DOM após animação
            setTimeout(() => {
              this.remove();
              atualizarContador();
            }, 300);
          }
        });

        // Adicionar cursor pointer
        notif.style.cursor = 'pointer';
      });

      // Inicializar contador
      atualizarContador();
    });
  </script>

</body>
</html>