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
