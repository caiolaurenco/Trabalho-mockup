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
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 60px);
            padding: 20px;
        }

        .form-container {
            background: white;
            padding: 30px;
            width: 380px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            margin-bottom: 16px;
            border-radius: 8px;
            border: 1px solid #bbb;
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

      

            <div class="lupa">
                <img src="../imagem/search (1).png" alt="lupa" />
                <p class="subtexto">BUSCAR</p>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="content-wrapper">
        <div class="form-container">
            <h2>Cadastro de Usuário</h2>

            <form id="formCadastro">

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
                    <option value="funcionario">Funcionário</option>
                    <option value="administrador">Administrador</option>
                </select>

                <button type="submit">Cadastrar</button>

                <div class="msg" id="msg"></div>
            </form>
        </div>
    </div>

    <script src="../Js/script.js"></script>
    <script>
    document.getElementById("formCadastro").addEventListener("submit", async function(e){
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData);

        const req = await fetch("../php/api.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        const res = await req.json();
        const msg = document.getElementById("msg");

        msg.innerHTML = res.message;
        msg.style.color = res.success ? "green" : "red";

        // 🔥 Redireciona após sucesso
        if (res.success) {
            setTimeout(() => {
                window.location.href = "index.php";
            }, 1000);
        }
    });
    </script>

</body>
</html>