function removerElementos() {
    const conteudo = document.getElementById("conteudo");
    if (conteudo) {
      conteudo.remove(); // remove o elemento <div id="conteudo"> inteiro
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