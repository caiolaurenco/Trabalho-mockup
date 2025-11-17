function removerElementos() {
    const conteudo = document.getElementById("conteudo");
    if (conteudo) {
      conteudo.remove(); 
    }
  } 

  
  function substituirImagem() {
    const images = document.querySelectorAll('.flex5 img');
    const images1 = document.querySelectorAll('.flex4 img');
    images.forEach(img => {
        img.src = 'imagem/bell.png'; 
    });
    images1.forEach(img => {
        img.src = 'imagem/bell.png'; 
    });
  }
  
function removerElementos() {
  const conteudo = document.getElementById("conteudo");
  if (conteudo) conteudo.remove();
}

function substituirImagem() {
  const images = document.querySelectorAll('.flex5 img, .flex4 img');
  images.forEach(img => img.src = 'imagem/bell.png');
}


function isValidEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function createElementFromHTML(htmlString) {
  const div = document.createElement('div');
  div.innerHTML = htmlString.trim();
  return div.firstChild;
}


document.addEventListener("DOMContentLoaded", function () {
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
        <p>Resultados fictícios — integre com backend para rotas reais.</p>
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

});