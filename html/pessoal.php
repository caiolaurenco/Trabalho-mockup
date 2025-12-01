<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #d9d9d9;
            margin: 0;
            padding: 0;
            min-height: 100vh;
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
            padding: 40px;
            width: 100%;
            max-width: 550px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideInUp 0.6s ease;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        h2 i {
            color: #667eea;
        }

        h3 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        h3 i {
            color: #667eea;
        }

        label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 14px 18px;
            margin-bottom: 20px;
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            box-sizing: border-box;
            font-size: 16px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        button[type="submit"] {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            border-radius: 12px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        .msg {
            margin-top: 15px;
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            font-weight: 600;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .usuarios-section {
            width: 100%;
            max-width: 900px;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideInUp 0.6s ease 0.2s both;
        }

        .lista-usuarios {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .usuario {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 25px;
            border-left: 5px solid #667eea;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .usuario::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .usuario:hover::before {
            left: 100%;
        }

        .usuario:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .usuario-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #dee2e6;
        }

        .usuario-nome {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .usuario-nome i {
            color: #667eea;
        }

        .usuario-cargo {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .cargo-funcionario {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .cargo-administrador {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .usuario-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-bottom: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #495057;
        }

        .info-item i {
            color: #667eea;
            width: 20px;
        }

        .info-item strong {
            color: #2c3e50;
        }

        .usuario-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
        }

        .btn-delete {
            flex: 1;
            padding: 12px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
        }

        .btn-limpar-todos {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-limpar-todos:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(231, 76, 60, 0.4);
        }

        .sem-usuarios {
            text-align: center;
            color: #95a5a6;
            font-style: italic;
            padding: 60px 20px;
            font-size: 18px;
        }

        .sem-usuarios i {
            font-size: 60px;
            color: #bdc3c7;
            margin-bottom: 20px;
            display: block;
        }

        .contador-usuarios {
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: 600;
        }

        .contador-usuarios i {
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 20px 10px;
            }

            .form-container, .usuarios-section {
                padding: 25px;
            }

            .usuario-info {
                grid-template-columns: 1fr;
            }

            h2 {
                font-size: 24px;
            }

            h3 {
                font-size: 20px;
            }
        }
    </style>

</head>
<body class="pessoal-page">

    <aside id="sidebar" class="sidebar">
        <ul>
            <li><a href="index.php"><img src="../imagem/casa.png" alt="casa">Início</a></li>
            <li><a href="pessoal.php"><img src="../imagem/msg.png" alt="msg"> Informações Pessoais</a></li>
            <li><a href="gerenciar_usuarios.php"><img src="../imagem/casa.png" alt="usuarios"> Gerenciar Usuários</a></li>
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

    <div class="content-wrapper">
        <div class="form-container">
            <h2>
                <i class="fas fa-user-plus"></i>
                Cadastro de Usuário
            </h2>

            <form id="formCadastro" class="formulario">

                <label><i class="fas fa-user"></i> Nome completo:</label>
                <input type="text" name="name" required placeholder="Digite o nome completo">

                <label><i class="fas fa-envelope"></i> E-mail:</label>
                <input type="email" name="email" required placeholder="exemplo@email.com">

                <label><i class="fas fa-id-card"></i> CPF:</label>
                <input type="text" name="cpf" id="cpf" maxlength="14" required placeholder="000.000.000-00">

                <label><i class="fas fa-lock"></i> Senha:</label>
                <input type="password" name="password" required placeholder="Mínimo 4 caracteres">

                <label><i class="fas fa-calendar"></i> Data de nascimento:</label>
                <input type="date" name="data_nasc" required>

                <label><i class="fas fa-briefcase"></i> Cargo:</label>
                <select name="cargo" required>
                    <option value="">Selecione um cargo</option>
                    <option value="funcionario">Funcionário</option>
                    <option value="administrador">Administrador</option>
                </select>

                <button type="submit">
                    <i class="fas fa-check"></i>
                    Cadastrar Usuário
                </button>

                <div class="msg" id="msg"></div>
            </form>
        </div>

        <div class="usuarios-section">
            <h3>
                <i class="fas fa-users"></i>
                Usuários Cadastrados
            </h3>

            <div class="contador-usuarios" id="contadorUsuarios">
                <i class="fas fa-info-circle"></i>
                <span id="numeroUsuarios">0</span> usuário(s) cadastrado(s)
            </div>

            <button class="btn-limpar-todos" id="btnLimparTodos" style="display: none;">
                <i class="fas fa-trash-alt"></i>
                Limpar Todos os Usuários
            </button>

            <div class="lista-usuarios" id="listaUsuarios">
                <div class="sem-usuarios">
                    <i class="fas fa-user-slash"></i>
                    Carregando usuários...
                </div>
            </div>
        </div>
    </div>

    <script src="../Js/script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        carregarUsuariosDoBanco();
        aplicarMascaraCPF();
    });

    function aplicarMascaraCPF() {
        const cpfInput = document.getElementById('cpf');
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length > 9) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
            } else if (value.length > 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
            } else if (value.length > 3) {
                value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
            }
            
            e.target.value = value;
        });
    }

    async function carregarUsuariosDoBanco() {
        const listaContainer = document.getElementById('listaUsuarios');
        const contadorSpan = document.getElementById('numeroUsuarios');
        const btnLimparTodos = document.getElementById('btnLimparTodos');
        
        try {
            const response = await fetch('../php/listar_ususarios.php');
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Erro ao carregar usuários');
            }
            
            const users = data.usuarios || [];
            contadorSpan.textContent = users.length;
            
            if (users.length === 0) {
                listaContainer.innerHTML = `
                    <div class="sem-usuarios">
                        <i class="fas fa-user-slash"></i>
                        Nenhum usuário cadastrado.
                    </div>
                `;
                btnLimparTodos.style.display = 'none';
                return;
            }
            
            btnLimparTodos.style.display = 'block';
            
            listaContainer.innerHTML = '';
            users.forEach((user) => {
                const div = document.createElement('div');
                div.className = 'usuario';
                div.innerHTML = `
                    <div class="usuario-header">
                        <div class="usuario-nome">
                            <i class="fas fa-user-circle"></i>
                            ${user.name}
                        </div>
                        <span class="usuario-cargo cargo-${user.cargo}">
                            ${user.cargo === 'administrador' ? '👑 Administrador' : '👤 Funcionário'}
                        </span>
                    </div>
                    <div class="usuario-info">
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span>${user.email}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-id-card"></i>
                            <span>${user.cpf || 'Não informado'}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>${user.data_nasc ? formatarData(user.data_nasc) : 'Não informada'}</span>
                        </div>
                    </div>
                    <div class="usuario-actions">
                        <button class="btn-delete" onclick="excluirUsuarioDoBanco(${user.id}, '${user.name.replace(/'/g, "\\'")}')">
                            <i class="fas fa-trash"></i>
                            Excluir Usuário
                        </button>
                    </div>
                `;
                listaContainer.appendChild(div);
            });
        } catch (e) {
            console.error('Erro ao carregar usuários:', e);
            listaContainer.innerHTML = `
                <div class="sem-usuarios">
                    <i class="fas fa-exclamation-triangle"></i>
                    Erro ao carregar usuários: ${e.message}
                </div>
            `;
            btnLimparTodos.style.display = 'none';
        }
    }

    function formatarData(data) {
        if (!data) return 'Não informada';
        const partes = data.split('-');
        if (partes.length === 3) {
            return `${partes[2]}/${partes[1]}/${partes[0]}`;
        }
        return data;
    }

    async function excluirUsuarioDoBanco(id, nome) {
        if (id === 1) {
            alert('⚠️ O usuário administrador padrão não pode ser excluído!');
            return;
        }

        if (confirm(`❌ Deseja realmente excluir o usuário "${nome}"?`)) {
            try {
                const response = await fetch('../php/excluir_usuario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                });

                const result = await response.json();

                if (result.success) {
                    mostrarMensagem('✅ Usuário excluído com sucesso!', 'success');
                    await carregarUsuariosDoBanco();
                } else {
                    mostrarMensagem('❌ Erro: ' + result.message, 'error');
                }
            } catch (e) {
                console.error('Erro ao excluir:', e);
                mostrarMensagem('❌ Erro ao excluir usuário', 'error');
            }
        }
    }

    document.getElementById('btnLimparTodos').addEventListener('click', async function() {
        if (confirm('⚠️ ATENÇÃO! Deseja realmente excluir TODOS os usuários cadastrados (exceto o admin padrão)?\n\nEsta ação não pode ser desfeita!')) {
            if (confirm('🚨 Última confirmação: Tem certeza absoluta?')) {
                try {
                    mostrarMensagem('⏳ Excluindo usuários...', 'loading');
                    
                    const response = await fetch('../php/listar_ususarios.php');
                    const data = await response.json();
                    
                    if (data.success && data.usuarios) {
                        let excluidos = 0;
                        for (const user of data.usuarios) {
                            if (user.id !== 1) {
                                await fetch('../php/excluir_usuario.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ id: user.id })
                                });
                                excluidos++;
                            }
                        }
                        
                        await carregarUsuariosDoBanco();
                        mostrarMensagem(`✅ ${excluidos} usuário(s) foram excluídos!`, 'success');
                    }
                } catch (e) {
                    console.error('Erro:', e);
                    mostrarMensagem('❌ Erro ao limpar usuários.', 'error');
                }
            }
        }
    });

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function mostrarMensagem(texto, tipo) {
        const msg = document.getElementById("msg");
        msg.innerHTML = texto;
        
        if (tipo === 'success') {
            msg.style.color = "#27ae60";
            msg.style.backgroundColor = "#eafaf1";
        } else if (tipo === 'error') {
            msg.style.color = "#e74c3c";
            msg.style.backgroundColor = "#fee";
        } else {
            msg.style.color = "#0066cc";
            msg.style.backgroundColor = "#e6f2ff";
        }
        
        setTimeout(() => {
            msg.innerHTML = '';
            msg.style.backgroundColor = 'transparent';
        }, 5000);
    }

    document.getElementById("formCadastro").addEventListener("submit", async function(e){
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        if (!data.name || !data.email || !data.cpf || !data.password || !data.data_nasc || !data.cargo) {
            mostrarMensagem("❌ Por favor, preencha todos os campos.", "error");
            return;
        }

        if (!isValidEmail(data.email)) {
            mostrarMensagem("❌ Por favor, insira um e-mail válido.", "error");
            return;
        }

        mostrarMensagem("⏳ Cadastrando usuário...", "loading");

        try {
            const req = await fetch("../php/api.php", {
                method: "POST",
                headers: { 
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(data)
            });

            const contentType = req.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                const textResponse = await req.text();
                console.error("Resposta não é JSON:", textResponse);
                throw new Error("Servidor retornou formato inválido (esperado JSON)");
            }

            const res = await req.json();

            mostrarMensagem(
                res.success ? "✅ " + res.message : "❌ " + res.message, 
                res.success ? "success" : "error"
            );

            if (res.success) {
                await carregarUsuariosDoBanco();
                this.reset();
                
                setTimeout(() => {
                    window.location.href = "index.php";
                }, 2000);
            }
        } catch (error) {
            console.error("Erro ao cadastrar:", error);
            mostrarMensagem("❌ Erro ao conectar com o servidor: " + error.message, "error");
        }
    });

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
        }
    });
    </script>

</body>
</html>