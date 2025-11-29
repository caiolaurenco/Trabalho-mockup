<?php
session_start();
include "../php/db.php";

$stmt = $mysqli->prepare("SELECT id, name, email, cpf, data_nasc, cargo, criado_em, ultimo_acesso FROM usuarios ORDER BY criado_em DESC");
$stmt->execute();
$result = $stmt->get_result();
$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 32px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header h1 i {
            color: #667eea;
        }

        .btn-voltar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-voltar:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .search-bar {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-bar input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-bar i {
            color: #667eea;
            font-size: 20px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .stat-icon.users {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-icon.admins {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .stat-icon.funcionarios {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .stat-info h3 {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .stat-info p {
            font-size: 32px;
            color: #2c3e50;
            font-weight: bold;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .user-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .user-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .user-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .user-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .user-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .user-info h3 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .user-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .user-badge.admin {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .user-badge.funcionario {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .user-details {
            margin: 20px 0;
        }

        .user-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: #7f8c8d;
            font-size: 14px;
        }

        .user-detail i {
            width: 20px;
            color: #667eea;
        }

        .user-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            flex: 1;
            padding: 12px;
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

        .btn-edit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-edit:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-delete {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-delete:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10000;
            animation: fadeIn 0.3s ease;
            overflow-y: auto;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            border-radius: 25px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.4s ease;
            position: relative;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #ecf0f1;
        }

        .modal-header h2 {
            color: #2c3e50;
            font-size: 28px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .modal-header h2 i {
            color: #667eea;
        }

        .modal-close {
            background: #e74c3c;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: #c0392b;
            transform: rotate(90deg);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-submit {
            flex: 1;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-cancel {
            flex: 1;
            padding: 16px;
            background: #ecf0f1;
            color: #2c3e50;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #bdc3c7;
        }

        .no-users {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .no-users i {
            font-size: 80px;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .no-users h3 {
            color: #7f8c8d;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .no-users p {
            color: #95a5a6;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }

            .header h1 {
                font-size: 24px;
            }

            .users-grid {
                grid-template-columns: 1fr;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .modal-content {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <i class="fas fa-users-cog"></i>
                Gerenciar Usuários
            </h1>
            <a href="index.php" class="btn-voltar">
                <i class="fas fa-arrow-left"></i>
                Voltar ao Início
            </a>
        </div>

        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Buscar por nome, email ou CPF..." 
                onkeyup="filtrarUsuarios()"
            >
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>Total de Usuários</h3>
                    <p id="totalUsers"><?php echo count($usuarios); ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon admins">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-info">
                    <h3>Administradores</h3>
                    <p id="totalAdmins">
                        <?php echo count(array_filter($usuarios, fn($u) => $u['cargo'] === 'administrador')); ?>
                    </p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon funcionarios">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-info">
                    <h3>Funcionários</h3>
                    <p id="totalFuncionarios">
                        <?php echo count(array_filter($usuarios, fn($u) => $u['cargo'] === 'funcionario')); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="users-grid" id="usersGrid">
            <?php if (empty($usuarios)): ?>
                <div class="no-users" style="grid-column: 1 / -1;">
                    <i class="fas fa-user-slash"></i>
                    <h3>Nenhum usuário encontrado</h3>
                    <p>Cadastre novos usuários para gerenciá-los aqui</p>
                </div>
            <?php else: ?>
                <?php foreach ($usuarios as $user): ?>
                    <div class="user-card" data-user='<?php echo json_encode($user); ?>'>
                        <div class="user-header">
                            <div class="user-avatar">
                                <?php echo strtoupper(substr($user['name'], 0, 2)); ?>
                            </div>
                            <div class="user-info">
                                <h3><?php echo htmlspecialchars($user['name']); ?></h3>
                                <span class="user-badge <?php echo $user['cargo']; ?>">
                                    <?php echo ucfirst($user['cargo']); ?>
                                </span>
                            </div>
                        </div>

                        <div class="user-details">
                            <div class="user-detail">
                                <i class="fas fa-envelope"></i>
                                <span><?php echo htmlspecialchars($user['email']); ?></span>
                            </div>
                            <div class="user-detail">
                                <i class="fas fa-id-card"></i>
                                <span><?php echo htmlspecialchars($user['cpf'] ?? 'Não informado'); ?></span>
                            </div>
                            <div class="user-detail">
                                <i class="fas fa-calendar"></i>
                                <span>
                                    <?php 
                                    if ($user['data_nasc']) {
                                        echo date('d/m/Y', strtotime($user['data_nasc']));
                                    } else {
                                        echo 'Não informado';
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="user-detail">
                                <i class="fas fa-clock"></i>
                                <span>
                                    Criado em <?php echo date('d/m/Y', strtotime($user['criado_em'])); ?>
                                </span>
                            </div>
                        </div>

                        <div class="user-actions">
                            <button class="btn btn-edit" onclick='abrirModalEdicao(<?php echo json_encode($user); ?>)'>
                                <i class="fas fa-edit"></i>
                                Editar
                            </button>
                            <button class="btn btn-delete" onclick="confirmarExclusao(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['name']); ?>')">
                                <i class="fas fa-trash"></i>
                                Excluir
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal-overlay" id="modalEdicao">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <i class="fas fa-user-edit"></i>
                    Editar Usuário
                </h2>
                <button class="modal-close" onclick="fecharModal()">×</button>
            </div>

            <form id="formEdicao" onsubmit="salvarEdicao(event)">
                <input type="hidden" id="edit_id" name="id">

                <div class="form-group">
                    <label>Nome Completo</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" id="edit_email" name="email" required>
                </div>

                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" id="edit_cpf" name="cpf" maxlength="14">
                </div>

                <div class="form-group">
                    <label>Data de Nascimento</label>
                    <input type="date" id="edit_data_nasc" name="data_nasc">
                </div>

                <div class="form-group">
                    <label>Cargo</label>
                    <select id="edit_cargo" name="cargo" required>
                        <option value="funcionario">Funcionário</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nova Senha (deixe em branco para manter a atual)</label>
                    <input type="password" id="edit_password" name="password" placeholder="••••••••">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        Salvar Alterações
                    </button>
                    <button type="button" class="btn-cancel" onclick="fecharModal()">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModalEdicao(user) {
            document.getElementById('edit_id').value = user.id;
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_cpf').value = user.cpf || '';
            document.getElementById('edit_data_nasc').value = user.data_nasc || '';
            document.getElementById('edit_cargo').value = user.cargo;
            document.getElementById('edit_password').value = '';

            document.getElementById('modalEdicao').classList.add('active');
        }

        function fecharModal() {
            document.getElementById('modalEdicao').classList.remove('active');
        }

        async function salvarEdicao(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData);

            try {
                const response = await fetch('../php/editar_usuario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ Usuário atualizado com sucesso!');
                    location.reload();
                } else {
                    alert('❌ Erro: ' + result.message);
                }
            } catch (error) {
                alert('❌ Erro ao salvar alterações');
                console.error(error);
            }
        }

        function confirmarExclusao(id, nome) {
            if (id === 1) {
                alert('⚠️ O usuário administrador padrão não pode ser excluído!');
                return;
            }

            if (confirm(`❌ Deseja realmente excluir o usuário "${nome}"?\n\nEsta ação não pode ser desfeita!`)) {
                excluirUsuario(id);
            }
        }

        async function excluirUsuario(id) {
            try {
                const response = await fetch('../php/excluir_usuario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                });

                const result = await response.json();

                if (result.success) {
                    alert('✅ Usuário excluído com sucesso!');
                    location.reload();
                } else {
                    alert('❌ Erro: ' + result.message);
                }
            } catch (error) {
                alert('❌ Erro ao excluir usuário');
                console.error(error);
            }
        }

        function filtrarUsuarios() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.user-card');

            cards.forEach(card => {
                const userData = JSON.parse(card.getAttribute('data-user'));
                const texto = `${userData.name} ${userData.email} ${userData.cpf || ''}`.toLowerCase();

                if (texto.includes(input)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        document.getElementById('modalEdicao').addEventListener('click', function(e) {
            if (e.target === this) {
                fecharModal();
            }
        });

        document.getElementById('edit_cpf').addEventListener('input', function(e) {
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
    </script>
</body>
</html>