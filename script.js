function removerElementos() {
    const conteudo = document.getElementById("conteudo");
    if (conteudo) {
      conteudo.remove(); 
    }
  } 

  
  function substituirImagem() {
    const img = document.getElementById('imagem');
    const srcAtual = img.getAttribute('src');
    const imagem1 = 'imagem/notification.png'; 
    const imagem2 = 'imagem/bell.png'; 
    if (srcAtual === imagem/notification.png) {
        img.setAttribute('src', imagem/bell.png);
    } else {
        img.setAttribute('src', imagem/notification.png);
    }
}

document.addEventListener("DOMContentLoaded", function () {
  const menuButton = document.getElementById("menu-button");
  const sidebar = document.getElementById("sidebar");

 
  menuButton.addEventListener("click", (e) => {
    e.stopPropagation(); 
    sidebar.classList.toggle("active");
  });

 
  sidebar.addEventListener("click", (e) => {
    e.stopPropagation();
  });

  
  document.addEventListener("click", () => {
    sidebar.classList.remove("active");
  });
});
