<?php
session_start();
include "db.php";

// Variáveis para mensagens
$mensagem = '';
$tipo_mensagem = '';

// Processar o formulário de cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnCadastro'])) {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $perfil = $_POST['perfil'] ?? 'funcionario';
    $cpf = trim($_POST['cpf'] ?? '');
    $data_nasc = $_POST['data_nasc'] ?? '';

    // Validações
    $erros = [];
    
    if (empty($nome)) {
        $erros[] = "Nome é obrigatório.";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "E-mail inválido.";
    }
    
    if (empty($senha) || strlen($senha) < 4) {
        $erros[] = "Senha deve ter no mínimo 4 caracteres.";
    }
    
    if (empty($cpf)) {
        $erros[] = "CPF é obrigatório.";
    }
    
    if (empty($data_nasc)) {
        $erros[] = "Data de nascimento é obrigatória.";
    }
    
    // Verificar se email já existe
    if (empty($erros)) {
        $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $erros[] = "E-mail já cadastrado no sistema.";
        }
        $stmt->close();
    }
    
    // Se não houver erros, inserir no banco
    if (empty($erros)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        $stmt = $mysqli->prepare("INSERT INTO usuarios (name, email, password, cpf, data_nasc, cargo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nome, $email, $senha_hash, $cpf, $data_nasc, $perfil);
        
        if ($stmt->execute()) {
            $mensagem = "Usuário cadastrado com sucesso!";
            $tipo_mensagem = "success";
        } else {
            $mensagem = "Erro ao cadastrar usuário: " . $stmt->error;
            $tipo_mensagem = "error";
        }
        
        $stmt->close();
    } else {
        $mensagem = implode("<br>", $erros);
        $tipo_mensagem = "error";
    }
}

// Buscar todos os usuários cadastrados
$usuarios = [];
$query = "SELECT id, name, email, cpf, cargo, data_nasc FROM usuarios ORDER BY id DESC";
$result = $mysqli->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestão de Usuários</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .mensagem-sistema {
      padding: 15px;
      margin: 20px auto;
      max-width: 800px;
      border-radius: 10px;
      font-size: 16px;
      text-align: center;
    }
    
    .mensagem-sistema.success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    
    .mensagem-sistema.error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    
    .usuario {
      position: relative;
    }
    
    .btn-excluir {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #e74c3c;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      transition: background-color 0.3s;
    }
    
    .btn-excluir:hover {
      background-color: #c0392b;
    }
    
    .sem-usuarios {
      text-align: center;
      padding: 40px;
      color: #666;
      font-size: 18px;
    }
  </style>
</head>
<body class="pessoal-page">
    <aside id="sidebar" class="sidebar">
    <ul>
     <li><a href="index.php"><img src="imagem/casa.png" alt="casa">Início</a></li>
      <li><a href="pessoal.php"><img src="imagem/msg.png" alt="msg"> Informações Pessoais</a></li>
      <li><a href="index.php"><img src="imagem/front-of-bus.png" alt="bus2"> Rotas</a></li>
      <li><a href="rotas2.php"><img src="imagem/bus.png" alt="bus"> Gestão de Rotas</a></li>
      <li><a href="horario.php"><img src="imagem/lugar.png" alt="lugar"> Quadro de Horários</a></li>
      <li><a href="notific.php"><img src="imagem/carta.png" alt="carta">Relatórios</a></li>
      <li><a href="buscar.php"><img src="imagem/search (1).png" alt="search"> Buscar</a></li>
      <li><a href="capa.php"><img src="imagem/sair.png" alt="search"> Sair</a></li>
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

  <?php if (!empty($mensagem)): ?>
  <div class="mensagem-sistema <?php echo $tipo_mensagem; ?>">
    <?php echo $mensagem; ?>
  </div>
  <?php endif; ?>

  <div class="container">
    <h2>Gestão de Usuários</h2>

    <form class="formulario" method="POST" action="">
      <input type="text" name="nome" placeholder="Nome completo" required>
      <input type="email" name="email" placeholder="E-mail" required>
      <input type="password" name="senha" placeholder="Senha (mínimo 4 caracteres)" required>
      <input type="text" name="cpf" placeholder="CPF (Ex: 000.000.000-00)" required>
      <input type="date" name="data_nasc" placeholder="Data de Nascimento" required>
      <select name="perfil" required>
        <option value="">Selecionar perfil</option>
        <option value="administrador">Administrador</option>
        <option value="funcionario">Funcionário</option>
      </select>
      <button type="submit" name="btnCadastro">Cadastrar Usuário</button>
    </form>

    <h3>Usuários cadastrados (<?php echo count($usuarios); ?>)</h3>
    <div class="lista-usuarios">
      <?php if (empty($usuarios)): ?>
        <div class="sem-usuarios">
          Nenhum usuário cadastrado ainda.
        </div>
      <?php else: ?>
        <?php foreach ($usuarios as $usuario): ?>
        <div class="usuario" data-id="<?php echo $usuario['id']; ?>">
          <p><strong><?php echo htmlspecialchars($usuario['name']); ?></strong></p>
          <p>Email: <?php echo htmlspecialchars($usuario['email']); ?></p>
          <p>CPF: <?php echo htmlspecialchars($usuario['cpf']); ?></p>
          <p>Data Nasc: <?php echo date('d/m/Y', strtotime($usuario['data_nasc'])); ?></p>
          <p>Perfil: <?php echo ucfirst($usuario['cargo']); ?></p>
          <button class="btn-excluir" onclick="excluirUsuario(<?php echo $usuario['id']; ?>, '<?php echo htmlspecialchars($usuario['name']); ?>')">
            Excluir
          </button>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <script>
    function excluirUsuario(id, nome) {
      if (confirm('Tem certeza que deseja excluir o usuário "' + nome + '"?')) {
        // Criar formulário temporário para enviar requisição POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'excluir_usuario.php';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = id;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
      }
    }
    
    // Auto-ocultar mensagem após 5 segundos
    setTimeout(function() {
      const mensagem = document.querySelector('.mensagem-sistema');
      if (mensagem) {
        mensagem.style.transition = 'opacity 0.5s';
        mensagem.style.opacity = '0';
        setTimeout(() => mensagem.remove(), 500);
      }
    }, 5000);
  </script>

</body>
</html>