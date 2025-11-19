// Funções de notificações
function removerElementos() {
  const conteudo = document.getElementById("conteudo");
  if (conteudo) conteudo.remove();
}

function substituirImagem() {
  const images = document.querySelectorAll('.flex5 img, .flex4 img');
  images.forEach(img => img.src = 'imagem/bell.png');
}

// Validação de email
function isValidEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function createElementFromHTML(htmlString) {
  const div = document.createElement('div');
  div.innerHTML = htmlString.trim();
  return div.firstChild;
}

// DOMContentLoaded principal
document.addEventListener("DOMContentLoaded", function () {
  // Menu lateral (sidebar)
  const menuButton = document.getElementById("menu-button");
  const sidebar = document.getElementById("sidebar");
  
  if (menuButton && sidebar) {
    menuButton.addEventListener("click", (e) => {
      e.stopPropagation();
      sidebar.classList.toggle("active");
      menuButton.setAttribute('aria-expanded', sidebar.classList.contains('active'));
    });

    document.addEventListener("click", () => sidebar.classList.remove("active"));
    sidebar.addEventListener("click", (e) => e.stopPropagation());
  }

  // Sistema de busca
  const buscarForm = document.querySelector('.form-busca');
  if (buscarForm) {
    let resultados = document.querySelector('.resultados-busca');
    if (!resultados) {
      resultados = document.createElement('div');
      resultados.className = 'resultados-busca';
      buscarForm.parentNode.insertBefore(resultados, buscarForm.nextSibling);
    }

    buscarForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const input = buscarForm.querySelector('input[type="text"]') || buscarForm.querySelector('input');
      const q = input ? input.value.trim() : '';
      resultados.innerHTML = '';

      if (!q || q.length < 3) {
        resultados.innerHTML = '<p>Digite ao menos 3 caracteres para buscar.</p>';
        return;
      }

      const item = document.createElement('div');
      item.className = 'resultado-item';
      item.innerHTML = `<p><strong>Resultados para:</strong> ${q}</p>
                        <p>Exibindo resultados fictícios (integre com backend para resultados reais).</p>`;
      resultados.appendChild(item);
    });
  }

  // Sistema de usuários
  const userForm = document.querySelector('.formulario');
  const usuariosContainer = document.querySelector('.lista-usuarios');
  const USERS_KEY = 'mockup_users_v1';

  function loadUsers() {
    try {
      const raw = localStorage.getItem(USERS_KEY);
      return raw ? JSON.parse(raw) : [];
    } catch (e) {
      return [];
    }
  }

  function saveUsers(users) {
    localStorage.setItem(USERS_KEY, JSON.stringify(users));
  }

  function renderUsers() {
    if (!usuariosContainer) return;
    usuariosContainer.innerHTML = '';
    const users = loadUsers();
    if (users.length === 0) {
      usuariosContainer.innerHTML = '<p>Nenhum usuário cadastrado.</p>';
      return;
    }
    users.forEach(u => {
      const div = document.createElement('div');
      div.className = 'usuario';
      div.innerHTML = `<p><strong>${u.name}</strong></p>
                       <p>Email: ${u.email}</p>
                       <p>Perfil: ${u.profile}</p>`;
      usuariosContainer.appendChild(div);
    });
  }

  if (userForm) {
    renderUsers();

    userForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const nameInput = userForm.querySelector('input[type="text"]');
      const emailInput = userForm.querySelector('input[type="email"]');
      const select = userForm.querySelector('select');

      const name = nameInput ? nameInput.value.trim() : '';
      const email = emailInput ? emailInput.value.trim() : '';
      const profile = select ? (select.value || select.options[select.selectedIndex].text) : '';

      const errors = [];
      if (!name) errors.push('Nome é obrigatório.');
      if (!email || !isValidEmail(email)) errors.push('Informe um e-mail válido.');
      if (!profile) errors.push('Selecione um perfil.');

      if (errors.length > 0) {
        alert(errors.join('\n'));
        return;
      }

      const users = loadUsers();
      users.push({ name, email, profile });
      saveUsers(users);
      renderUsers();

      if (nameInput) nameInput.value = '';
      if (emailInput) emailInput.value = '';
      if (select) select.selectedIndex = 0;
    });
  }

  // Modal de busca
  const buscarBtn = document.getElementById('buscar2') || document.getElementById('buscar1');
  if (buscarBtn) {
    buscarBtn.style.cursor = 'pointer';
    buscarBtn.addEventListener('click', (e) => {
      e.preventDefault();
      const partida = document.getElementById('partida1') ? document.getElementById('partida1').value : '';
      const destino = document.getElementById('destino1') ? document.getElementById('destino1').value : '';
      const data = document.getElementById('data1') ? document.getElementById('data1').value : '';
      const partidaChegada = document.getElementById('pc1') ? document.getElementById('pc1').value : '';
      const hora = document.getElementById('hora1') ? document.getElementById('hora1').value : '';

      const content = `
        <h3>Resumo da busca</h3>
        <p><strong>Partida:</strong> ${partida || '—'}</p>
        <p><strong>Destino:</strong> ${destino || '—'}</p>
        <p><strong>Data:</strong> ${data || '—'}</p>
        <p><strong>Partida/Chegada:</strong> ${partidaChegada || '—'}</p>
        <p><strong>Hora aproximada:</strong> ${hora || '—'}</p>
        <p>Resultados fictícios – integre com backend para rotas reais.</p>
      `;
      showModal(content);
    });
  }

  function showModal(htmlContent) {
    if (document.getElementById('app-modal')) return;

    const overlay = document.createElement('div');
    overlay.id = 'app-modal-overlay';
    overlay.style = 'position:fixed;inset:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:9999;';

    const modal = document.createElement('div');
    modal.id = 'app-modal';
    modal.style = 'background:#fff;padding:20px;border-radius:8px;max-width:90%;max-height:80%;overflow:auto;';
    modal.innerHTML = htmlContent;

    const closeBtn = document.createElement('button');
    closeBtn.textContent = 'Fechar';
    closeBtn.style = 'margin-top:12px;padding:6px 12px;';
    closeBtn.addEventListener('click', () => document.body.removeChild(overlay));

    modal.appendChild(closeBtn);
    overlay.appendChild(modal);
    overlay.addEventListener('click', (e) => { if (e.target === overlay) document.body.removeChild(overlay); });

    document.body.appendChild(overlay);
  }

  // ===== EFEITOS HOVER PARA OS CARDS DO INDEX =====
  const menuItems = document.querySelectorAll('.menu-item');
  
  // Função para aplicar efeito hover
  function applyHoverEffect(item) {
    // Zoom e elevação
    item.style.transform = 'translateY(-8px) scale(1.05)';
    item.style.transition = 'all 0.3s ease';
    
    // Cria overlay escuro se não existir
    if (!item.querySelector('.hover-overlay')) {
      const overlay = document.createElement('div');
      overlay.className = 'hover-overlay';
      overlay.style.cssText = `
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 15px;
        pointer-events: none;
        z-index: 1;
        opacity: 1;
        transition: opacity 0.3s ease;
      `;
      item.appendChild(overlay);
    }
    
    // Efeito na imagem
    const img = item.querySelector('img');
    if (img) {
      img.style.transform = 'scale(1.1)';
      img.style.transition = 'transform 0.3s ease';
    }
    
    // Efeito no texto
    const h3 = item.querySelector('h3');
    if (h3) {
      h3.style.transform = 'scale(1.02)';
      h3.style.transition = 'transform 0.3s ease';
    }
  }
  
  // Função para remover efeito hover
  function removeHoverEffect(item) {
    // Remove zoom e elevação
    item.style.transform = 'translateY(0) scale(1)';
    
    // Remove overlay com fade out
    const overlay = item.querySelector('.hover-overlay');
    if (overlay) {
      overlay.style.opacity = '0';
      setTimeout(() => {
        if (overlay.parentNode) {
          overlay.remove();
        }
      }, 300);
    }
    
    // Remove efeito da imagem
    const img = item.querySelector('img');
    if (img) {
      img.style.transform = 'scale(1)';
    }
    
    // Remove efeito do texto
    const h3 = item.querySelector('h3');
    if (h3) {
      h3.style.transform = 'scale(1)';
    }
  }
  
  menuItems.forEach(item => {
    // Eventos para desktop (mouse)
    item.addEventListener('mouseenter', function() {
      applyHoverEffect(this);
    });
    
    item.addEventListener('mouseleave', function() {
      removeHoverEffect(this);
    });
    
    // Eventos para mobile (toque)
    item.addEventListener('touchstart', function(e) {
      // Remove efeito de todos os outros cards
      menuItems.forEach(otherItem => {
        if (otherItem !== this) {
          removeHoverEffect(otherItem);
        }
      });
      applyHoverEffect(this);
    });
    
    // Quando toca fora, remove o efeito
    item.addEventListener('touchend', function() {
      setTimeout(() => {
        removeHoverEffect(this);
      }, 200);
    });
  });
  
  // Remove efeito ao tocar em qualquer lugar da tela
  document.addEventListener('touchstart', function(e) {
    if (!e.target.closest('.menu-item')) {
      menuItems.forEach(item => {
        removeHoverEffect(item);
      });
    }
  });
});

// Animação suave para links âncora
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// Validação de formulários
const forms = document.querySelectorAll('form');
forms.forEach(form => {
  form.addEventListener('submit', (e) => {
    const inputs = form.querySelectorAll('input[required]');
    let isValid = true;
    
    inputs.forEach(input => {
      if (!input.value.trim()) {
        isValid = false;
        input.style.borderColor = 'red';
        
        setTimeout(() => {
          input.style.borderColor = '';
        }, 2000);
      }
    });
    
    if (!isValid) {
      e.preventDefault();
      alert('Por favor, preencha todos os campos obrigatórios.');
    }
  });
});