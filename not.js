function removerElementos() {
    const conteudo = document.getElementById("conteudo");
    if (conteudo) {
      conteudo.remove(); // remove o elemento <div id="conteudo"> inteiro
    }
  } 

  function trocarImagem() {
    const img = document.getElementById("minhaImagem");
    if (img.src.includes("bell.png")) {
      img.src = "silent.png";
    } else {
      img.src = "bell.png";
    }
  }