<?php
include "../php/db.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quadro de Horários</title>
    <link rel="stylesheet" href="../Css/style.css">
    <style>
        .horario-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        
        .filtros {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .filtros label {
            font-weight: bold;
            color: #003366;
        }
        
        .filtros select, .filtros input {
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            min-width: 200px;
        }
        
        .tabela-horarios {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .linha-horario {
            display: grid;
            grid-template-columns: 100px 1fr;
            border-bottom: 1px solid #eee;
        }
        
        .linha-horario:last-child {
            border-bottom: none;
        }
        
        .linha-nome {
            background: #003366;
            color: white;
            padding: 15px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .horarios {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 10px;
            padding: 15px;
            align-items: center;
        }
        
        .hora-item {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            color: #003366;
            transition: all 0.3s ease;
        }
        
        .hora-item:hover {
            background: #003366;
            color: white;
            transform: translateY(-2px);
        }
        
        .sem-horarios {
            grid-column: 1 / -1;
            text-align: center;
            color: #6c757d;
            font-style: italic;
        }
        
        .header-info {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header-info h1 {
            color: #003366;
            margin-bottom: 10px;
        }
        
        .data-atual {
            font-size: 18px;
            color: #666;
            font-weight: bold;
        }
    </style>
</head>
<body class="horario-page">
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

    <div class="horario-container">
        <div class="header-info">
            <h1>FERROVIA FUTURO</h1>
            <div class="data-atual" id="data-atual"><?php echo date('d/m/Y'); ?></div>
        </div>
        
        <div class="filtros">
            <label for="estacao-select">Estação:</label>
            <select id="estacao-select" class="estacao-select">
                <option value="">Selecionar estação</option>
                <option value="central">Estação Central</option>
                <option value="norte">Estação Norte</option>
                <option value="sul">Estação Sul</option>
                <option value="leste">Estação Leste</option>
                <option value="oeste">Estação Oeste</option>
            </select>
            
            <label for="data-input">Data:</label>
            <br>
            <input type="date" id="data-input" value="<?php echo date('Y-m-d'); ?>">
            <div class="spacer" style="width: 5px;">
            </div>
            <label for="linha-select">Linha:</label>
            <select id="linha-select">
                <option value="todas">Todas as Linhas</option>
                <option value="1">Linha 1 - Centro</option>
                <option value="2">Linha 2 - Norte/Sul</option>
                <option value="3">Linha 3 - Leste/Oeste</option>
            </select>
        </div>
        
        <div class="tabela-horarios" id="tabela-horarios">
            <div class="linha-horario">
                <div class="linha-nome">Linha 1</div>
                <div class="horarios">
                    <div class="hora-item">--:--</div>
                    <div class="hora-item">--:--</div>
                    <div class="hora-item">--:--</div>
                </div>
            </div>
            <div class="linha-horario">
                <div class="linha-nome">Linha 2</div>
                <div class="horarios">
                    <div class="hora-item">--:--</div>
                    <div class="hora-item">--:--</div>
                    <div class="hora-item">--:--</div>
                </div>
            </div>
            <div class="linha-horario">
                <div class="linha-nome">Linha 3</div>
                <div class="horarios">
                    <div class="hora-item">--:--</div>
                    <div class="hora-item">--:--</div>
                    <div class="hora-item">--:--</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const horariosCompletos = {
            central: {
                '1': ['06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '17:00', '17:30', '18:00', '18:30', '19:00'],
                '2': ['06:15', '06:45', '07:15', '07:45', '08:15', '08:45', '09:15', '17:15', '17:45', '18:15', '18:45', '19:15'],
                '3': ['06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '17:30', '18:00', '18:30', '19:00', '19:30']
            },
            norte: {
                '1': ['05:45', '06:15', '06:45', '07:15', '07:45', '08:15', '08:45', '16:45', '17:15', '17:45', '18:15', '18:45'],
                '2': ['06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '17:00', '17:30', '18:00', '18:30', '19:00'],
                '3': ['06:15', '06:45', '07:15', '07:45', '08:15', '08:45', '09:15', '17:15', '17:45', '18:15', '18:45', '19:15']
            },
            sul: {
                '1': ['06:10', '06:40', '07:10', '07:40', '08:10', '08:40', '09:10', '17:10', '17:40', '18:10', '18:40', '19:10'],
                '2': ['06:25', '06:55', '07:25', '07:55', '08:25', '08:55', '09:25', '17:25', '17:55', '18:25', '18:55', '19:25'],
                '3': ['06:40', '07:10', '07:40', '08:10', '08:40', '09:10', '09:40', '17:40', '18:10', '18:40', '19:10', '19:40']
            },
            leste: {
                '1': ['05:50', '06:20', '06:50', '07:20', '07:50', '08:20', '08:50', '16:50', '17:20', '17:50', '18:20', '18:50'],
                '2': ['06:05', '06:35', '07:05', '07:35', '08:05', '08:35', '09:05', '17:05', '17:35', '18:05', '18:35', '19:05'],
                '3': ['06:20', '06:50', '07:20', '07:50', '08:20', '08:50', '09:20', '17:20', '17:50', '18:20', '18:50', '19:20']
            },
            oeste: {
                '1': ['06:05', '06:35', '07:05', '07:35', '08:05', '08:35', '09:05', '17:05', '17:35', '18:05', '18:35', '19:05'],
                '2': ['06:20', '06:50', '07:20', '07:50', '08:20', '08:50', '09:20', '17:20', '17:50', '18:20', '18:50', '19:20'],
                '3': ['06:35', '07:05', '07:35', '08:05', '08:35', '09:05', '09:35', '17:35', '18:05', '18:35', '19:05', '19:35']
            }
        };

        function atualizarHorarios() {
            const estacaoSelect = document.getElementById('estacao-select');
            const linhaSelect = document.getElementById('linha-select');
            const tabela = document.getElementById('tabela-horarios');
            
            const estacao = estacaoSelect.value;
            const linhaFiltro = linhaSelect.value;
            
            console.log('Atualizando horários:', { estacao, linhaFiltro });
            
            if (!estacao) {
                const todasHoras = tabela.querySelectorAll('.hora-item');
                todasHoras.forEach(hora => hora.textContent = '--:--');
                return;
            }
            
            const horariosEstacao = horariosCompletos[estacao];
            if (!horariosEstacao) {
                console.error('Estação não encontrada:', estacao);
                return;
            }
            
            const linhas = tabela.querySelectorAll('.linha-horario');
            linhas.forEach(linhaElement => {
                const linhaNumero = linhaElement.querySelector('.linha-nome').textContent.replace('Linha ', '');
                const horariosContainer = linhaElement.querySelector('.horarios');
                
                if (linhaFiltro !== 'todas' && linhaFiltro !== linhaNumero) {
                    linhaElement.style.display = 'none';
                    return;
                }
                
                linhaElement.style.display = 'grid';
                
                const horarios = horariosEstacao[linhaNumero] || [];
                
                horariosContainer.innerHTML = '';
                
                if (horarios.length === 0) {
                    const semHorarios = document.createElement('div');
                    semHorarios.className = 'sem-horarios';
                    semHorarios.textContent = 'Sem horários disponíveis';
                    horariosContainer.appendChild(semHorarios);
                } else {
                    horarios.forEach(horario => {
                        const horaItem = document.createElement('div');
                        horaItem.className = 'hora-item';
                        horaItem.textContent = horario;
                        horariosContainer.appendChild(horaItem);
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Sistema de horários inicializado');
            
            document.getElementById('estacao-select').addEventListener('change', atualizarHorarios);
            document.getElementById('linha-select').addEventListener('change', atualizarHorarios);
            document.getElementById('data-input').addEventListener('change', atualizarHorarios);
            
            const menuButton = document.getElementById("menu-button");
            const sidebar = document.getElementById("sidebar");
            
            if (menuButton && sidebar) {
                menuButton.addEventListener("click", (e) => {
                    e.stopPropagation();
                    sidebar.classList.toggle("active");
                });

                document.addEventListener("click", () => sidebar.classList.remove("active"));
                sidebar.addEventListener("click", (e) => e.stopPropagation());
            }
            
            const dataInput = document.getElementById('data-input');
            const dataAtual = document.getElementById('data-atual');
            
            dataInput.addEventListener('change', function() {
                const data = new Date(this.value);
                dataAtual.textContent = data.toLocaleDateString('pt-BR');
            });
        });
    </script>
</body>
</html>