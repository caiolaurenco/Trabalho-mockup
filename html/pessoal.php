<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../Css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: calc(100vh - 60px);
            padding: 40px 20px;
            gap: 40px;
        }

        .form-container {
            background: white;
            padding: 30px;
            width: 100%;
            max-width: 500px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #003366;
        }

        h3 {
            text-align: center;
            color: #003366;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            margin-bottom: 16px;
            border-radius: 8px;
            border: 1px solid #bbb;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #4A5CF1;
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #343f9c;
        }

        .msg {
            margin-top: 10px;
            text-align: center;
        }

        /* Estilos para lista de usuários */
        .usuarios-section {
            width: 100%;
            max-width: 800px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        .lista-usuarios {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .usuario {
            background-color: #ecf0f1;
            border-radius: 15px;
            padding: 25px;
            border-left: 5px solid #003366;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .usuario p {
            margin: 10px 0;
            font-size: 16px;
        }

        .usuario strong {
            color: #003366;
        }

        .sem-usuarios {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
    </style>

</head>
<body class="pessoal-page">

    <!-- Sidebar -->
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

    <!-- Navbar -->
    <nav>
        <div class="flex">
            <img src="../imagem/menu.png" alt="logo-menu" id="menu-button" />

            <div class="LOGO1">
                <img src="../imagem/logo1.JPG" alt="LOG" />
            </div>

            <div class="bus1">
                <img src="../imagem/bus.png" alt="bus1" />
                <p class="subtexto">MEU LOCAL</p>
            </div>

            <div class="bus2">
                <img src="../imagem/front-of-bus.png" alt="bus2" />
                <p class="subtexto">LINHAS</p>
            </div>

            <div class="lupa">
                <img src="../imagem/search (1).png" alt="lupa" />
                <p class="subtexto">BUSCAR</p>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="content-wrapper">
        <!-- Formulário de Cadastro -->
        <div class="form-container">
            <h2>Cadastro de Usuário</h2>

            <form id="formCadastro" class="formulario">

                <label>Nome completo:</label>
                <input type="text" name="name" required>

                <label>E-mail:</label>
                <input type="email" name="email" required>

                <label>CPF:</label>
                <input type="text" name="cpf" maxlength="20" required>

                <label>Senha:</label>
                <input type="password" name="password" required>

                <label>Data de nascimento:</label>
                <input type="date" name="data_nasc" required>

                <label>Cargo:</label>
                <select name="cargo" required>
                    <option value="">Selecione um cargo</option>
                    <option value="funcionario">Funcionário</option>
                    <option value="administrador">Administrador</option>
                </select>

                <button type="submit">Cadastrar</button>

                <div class="msg" id="msg"></div>
            </form>
        </div>

        <!-- Lista de Usuários Cadastrados -->
        <div class="usuarios-section">
            <h3>Usuários Cadastrados</h3>
            <div class="lista-usuarios" id="listaUsuarios">
                <p class="sem-usuarios">Carregando usuários...</p>
            </div>
        </div>
    </div>

    <script src="../Js/script.js"></script>
    <script>
    // Carregar usuários ao iniciar
    document.addEventListener('DOMContentLoaded', function() {
        carregarUsuarios();
    });

    // Função para carregar usuários do localStorage
    function carregarUsuarios() {
        const listaContainer = document.getElementById('listaUsuarios');
        const USERS_KEY = 'mockup_users_v1';
        
        try {
            const raw = localStorage.getItem(USERS_KEY);
            const users = raw ? JSON.parse(raw) : [];
            
            if (users.length === 0) {
                listaContainer.innerHTML = '<p class="sem-usuarios">Nenhum usuário cadastrado.</p>';
                return;
            }
            
            listaContainer.innerHTML = '';
            users.forEach(user => {
                const div = document.createElement('div');
                div.className = 'usuario';
                div.innerHTML = `
                    <p><strong>${user.name}</strong></p>
                    <p>Email: ${user.email}</p>
                    <p>CPF: ${user.cpf || 'Não informado'}</p>
                    <p>Data de Nascimento: ${user.data_nasc || 'Não informada'}</p>
                    <p>Cargo: ${user.cargo || user.profile || 'Não informado'}</p>
                `;
                listaContainer.appendChild(div);
            });
        } catch (e) {
            listaContainer.innerHTML = '<p class="sem-usuarios">Erro ao carregar usuários.</p>';
        }
    }

    // Função para salvar usuário no localStorage
    function salvarUsuario(userData) {
        const USERS_KEY = 'mockup_users_v1';
        try {
            const raw = localStorage.getItem(USERS_KEY);
            const users = raw ? JSON.parse(raw) : [];
            users.push(userData);
            localStorage.setItem(USERS_KEY, JSON.stringify(users));
            return true;
        } catch (e) {
            return false;
        }
    }

    // Enviar formulário
    document.getElementById("formCadastro").addEventListener("submit", async function(e){
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        // Validação básica
        if (!data.name || !data.email || !data.cpf || !data.password || !data.data_nasc || !data.cargo) {
            const msg = document.getElementById("msg");
            msg.innerHTML = "Por favor, preencha todos os campos.";
            msg.style.color = "red";
            return;
        }

        // Salvar no localStorage para exibição imediata
        salvarUsuario(data);

        // Enviar para o servidor
        const req = await fetch("../php/api.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        const res = await req.json();
        const msg = document.getElementById("msg");

        msg.innerHTML = res.message;
        msg.style.color = res.success ? "green" : "red";

        // Recarregar lista de usuários
        if (res.success) {
            carregarUsuarios();
            
            // Limpar formulário
            this.reset();
            
            // Redirecionar após 2 segundos
            setTimeout(() => {
                window.location.href = "index.php";
            }, 2000);
        }
    });
    </script>

</body>
</html>