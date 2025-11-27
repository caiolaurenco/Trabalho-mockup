<?php
include "../php/db.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Rotas - IoT</title>
    <link rel="stylesheet" href="../Css/style.css">
    <script src="https://unpkg.com/mqtt@4.3.7/dist/mqtt.min.js"></script>
    <style>
        .rotas-page {
            background: linear-gradient(135deg, #eae2e2ff 0%, #ffffffff 100%);
            min-height: 100vh;
        }

        .rotas-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .rotas-header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
            animation: fadeInDown 0.6s ease;
        }

        .rotas-header h1 {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .rotas-header p {
            font-size: 18px;
            opacity: 0.95;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mapa-rotas {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
            animation: fadeInUp 0.6s ease 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mapa-rotas img {
            width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .alertas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .alerta-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            border-left: 5px solid;
            animation: fadeInUp 0.6s ease both;
        }

        .alerta-card:nth-child(1) {
            border-left-color: #e74c3c;
            animation-delay: 0.3s;
        }

        .alerta-card:nth-child(2) {
            border-left-color: #f39c12;
            animation-delay: 0.4s;
        }

        .alerta-card:nth-child(3) {
            border-left-color: #e67e22;
            animation-delay: 0.5s;
        }

        .alerta-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        }

        .alerta-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .alerta-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 28px;
        }

        .alerta-card:nth-child(1) .alerta-icon {
            background: rgba(231, 76, 60, 0.1);
        }

        .alerta-card:nth-child(2) .alerta-icon {
            background: rgba(243, 156, 18, 0.1);
        }

        .alerta-card:nth-child(3) .alerta-icon {
            background: rgba(230, 126, 34, 0.1);
        }

        .alerta-titulo {
            flex: 1;
        }

        .alerta-titulo h3 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .alerta-titulo p {
            font-size: 14px;
            color: #7f8c8d;
            margin: 0;
        }

        .alerta-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-critico {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }

        .status-atencao {
            background: rgba(243, 156, 18, 0.15);
            color: #f39c12;
        }

        .status-alerta {
            background: rgba(230, 126, 34, 0.15);
            color: #e67e22;
        }

        /* Modal de Sensores */
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
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 35px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.4s ease;
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
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #ecf0f1;
        }

        .modal-header h2 {
            color: #2c3e50;
            font-size: 26px;
            margin: 0;
        }

        .modal-close {
            background: #e74c3c;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
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

        .sensor-data {
            display: grid;
            gap: 20px;
        }

        .sensor-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #3498db;
            transition: all 0.3s ease;
        }

        .sensor-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .sensor-label {
            font-size: 14px;
            color: #7f8c8d;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .sensor-value {
            font-size: 28px;
            color: #2c3e50;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sensor-unit {
            font-size: 18px;
            color: #7f8c8d;
            font-weight: normal;
        }

        .sensor-icon {
            font-size: 32px;
        }

        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .status-online {
            background: #27ae60;
        }

        .status-offline {
            background: #e74c3c;
        }

        .connection-status {
            background: white;
            padding: 15px 25px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .rotas-header h1 {
                font-size: 32px;
            }

            .alertas-grid {
                grid-template-columns: 1fr;
            }

            .modal-content {
                padding: 25px;
            }
        }
    </style>
</head>
<body class="rotas-page">
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

    <div class="rotas-container">
        <div class="rotas-header">
            <h1>Gestão de Rotas IoT</h1>
        </div>

      
        <div class="connection-status" id="connectionStatus">
            <span class="status-indicator status-offline" id="statusIndicator"></span>
            <span id="statusText">Conectando ao servidor MQTT...</span>
            <span class="loading" id="loadingSpinner"></span>
        </div>

        <div class="mapa-rotas">
            <img src="../imagem/Captura de tela 2025-05-26 105546.png" alt="Mapa das Rotas">
        </div>

        <div class="alertas-grid">
            <!-- Alerta Sensor 1 -->
            <div class="alerta-card" onclick="abrirModal('sensor1')">
                <div class="alerta-header">
                    <div class="alerta-icon">⚠️</div>
                    <div class="alerta-titulo">
                        <h3>Trem A está atrasado!</h3>
                        <p>Sensor 1 - Estação Central</p>
                    </div>
                </div>
                <span class="alerta-status status-critico">CRÍTICO</span>
                <p style="margin-top: 15px; color: #7f8c8d;">
                    <strong>Sensores:</strong> Temperatura, Distância, Umidade, Luminosidade
                </p>
            </div>

            <!-- Alerta Sensor 2 -->
            <div class="alerta-card" onclick="abrirModal('sensor2')">
                <div class="alerta-header">
                    <div class="alerta-icon">⚡</div>
                    <div class="alerta-titulo">
                        <h3>Trem B necessita de manutenção!</h3>
                        <p>Sensor 2 - Trilho Principal</p>
                    </div>
                </div>
                <span class="alerta-status status-atencao">ATENÇÃO</span>
                <p style="margin-top: 15px; color: #7f8c8d;">
                    <strong>Sensores:</strong> Distância Dupla, Detecção de Objetos
                </p>
            </div>

            <!-- Alerta Sensor 3 -->
            <div class="alerta-card" onclick="abrirModal('sensor3')">
                <div class="alerta-header">
                    <div class="alerta-icon">🔧</div>
                    <div class="alerta-titulo">
                        <h3>Trilho da ferrovia 1 para 2 danificado!</h3>
                        <p>Sensor 3 - Controle de Desvios</p>
                    </div>
                </div>
                <span class="alerta-status status-alerta">ALERTA</span>
                <p style="margin-top: 15px; color: #7f8c8d;">
                    <strong>Sensores:</strong> Distância, Servo Motores, Controle de Acesso
                </p>
            </div>
        </div>
    </div>

    <!-- Modal Sensor 1 -->
    <div class="modal-overlay" id="modalSensor1">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📊 Sensor 1 - Estação Central</h2>
                <button class="modal-close" onclick="fecharModal('sensor1')">×</button>
            </div>
            <div class="sensor-data">
                <div class="sensor-item">
                    <div class="sensor-label">🌡️ Temperatura</div>
                    <div class="sensor-value">
                        <span id="s1_temperatura">--</span>
                        <span class="sensor-unit">°C</span>
                    </div>
                </div>
                <div class="sensor-item">
                    <div class="sensor-label">📏 Distância</div>
                    <div class="sensor-value">
                        <span id="s1_distancia">--</span>
                        <span class="sensor-unit">cm</span>
                    </div>
                </div>
                <div class="sensor-item">
                    <div class="sensor-label">💧 Umidade</div>
                    <div class="sensor-value">
                        <span id="s1_umidade">--</span>
                        <span class="sensor-unit">%</span>
                    </div>
                </div>
                <div class="sensor-item">
                    <div class="sensor-label">💡 Luminosidade</div>
                    <div class="sensor-value">
                        <span id="s1_iluminacao">--</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sensor 2 -->
    <div class="modal-overlay" id="modalSensor2">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📊 Sensor 2 - Trilho Principal</h2>
                <button class="modal-close" onclick="fecharModal('sensor2')">×</button>
            </div>
            <div class="sensor-data">
                <div class="sensor-item">
                    <div class="sensor-label">📏 Sensor de Distância 1</div>
                    <div class="sensor-value">
                        <span id="s2_sensor1">--</span>
                        <span class="sensor-unit">cm</span>
                    </div>
                </div>
                <div class="sensor-item">
                    <div class="sensor-label">📏 Sensor de Distância 2</div>
                    <div class="sensor-value">
                        <span id="s2_sensor2">--</span>
                        <span class="sensor-unit">cm</span>
                    </div>
                </div>
                <div class="sensor-item">
                    <div class="sensor-label">🚨 Status dos Sensores</div>
                    <div class="sensor-value">
                        <span id="s2_status">--</span>
                    </div>
                </div>
                <div class="sensor-item">
                    <div class="sensor-label">💡 LED de Alerta</div>
                    <div class="sensor-value">
                        <span id="s2_led">--</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sensor 3 -->
    <div class="modal-overlay" id="modalSensor3">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📊 Sensor 3 - Controle de Desvios</h2>
                <button class="modal-close" onclick="fecharModal('sensor3')">×</button>
            </div>
            <div class="sensor-data">
                <div class="sensor-item">
                    <div class="sensor-label">📏 Distância do Objeto</div>
                    <div class="sensor-value">
                        <span id="s3_distancia">--</span>
                        <span class="sensor-unit">cm</span>
                    </div>
                </div>
                <div class="sensor-item">
                    <div class="sensor-label">🔄 Servo Motor 1</div>
                    <div class="sensor-value">
                        <span id="s3_servo1">--</span>
                        <span class="sensor-unit">°</span>
                    </div>
                </div>
                <div class="sensor-item">
                    <div class="sensor-label">🔄 Servo Motor 2</div>
                    <div class="sensor-value">
                        <span id="s3_servo2">--</span>
                        <span class="sensor-unit">°</span>
                    </div>
                </div>
                <div class="sensor-item">
                    <div class="sensor-label">🚦 Status do Sistema</div>
                    <div class="sensor-value">
                        <span id="s3_status">--</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../Js/script.js"></script>
    <script>
        // Configuração MQTT
        const BROKER = 'wss://broker.hivemq.com:8884/mqtt';
        let client;
        
        // Dados dos sensores
        const sensorData = {
            s1: {
                temperatura: '--',
                distancia: '--',
                umidade: '--',
                iluminacao: '--'
            },
            s2: {
                sensor1: '--',
                sensor2: '--',
                status: '--',
                led: '--'
            },
            s3: {
                distancia: '--',
                servo1: '--',
                servo2: '--',
                status: '--'
            }
        };

        // Conectar ao MQTT
        function conectarMQTT() {
            client = mqtt.connect(BROKER);

            client.on('connect', () => {
                console.log('✅ Conectado ao HiveMQ');
                atualizarStatus(true);
                
                // Subscrever aos tópicos do Sensor 1
                client.subscribe('s1/temperatura');
                client.subscribe('s1/distancia');
                client.subscribe('s1/umidade');
                client.subscribe('s1/iluminacao');
                
                // Subscrever aos tópicos do Sensor 2
                client.subscribe('s2/sensor1');
                client.subscribe('s2/sensor2');
                client.subscribe('s2/status');
                
                // Subscrever aos tópicos do Sensor 3
                client.subscribe('s3/distancia');
                client.subscribe('s3/servo1');
                client.subscribe('s3/servo2');
                client.subscribe('s3/status');
            });

            client.on('message', (topic, message) => {
                const valor = message.toString();
                console.log(`Recebido: ${topic} = ${valor}`);
                
                // Processar mensagens do Sensor 1
                if (topic === 's1/temperatura') {
                    sensorData.s1.temperatura = parseFloat(valor).toFixed(1);
                    atualizarDisplay('s1_temperatura', sensorData.s1.temperatura);
                } else if (topic === 's1/distancia') {
                    sensorData.s1.distancia = valor;
                    atualizarDisplay('s1_distancia', sensorData.s1.distancia);
                } else if (topic === 's1/umidade') {
                    sensorData.s1.umidade = parseFloat(valor).toFixed(1);
                    atualizarDisplay('s1_umidade', sensorData.s1.umidade);
                } else if (topic === 's1/iluminacao') {
                    sensorData.s1.iluminacao = valor;
                    atualizarDisplay('s1_iluminacao', sensorData.s1.iluminacao);
                }
                
                // Processar mensagens do Sensor 2
                else if (topic === 's2/sensor1') {
                    sensorData.s2.sensor1 = valor;
                    atualizarDisplay('s2_sensor1', sensorData.s2.sensor1);
                } else if (topic === 's2/sensor2') {
                    sensorData.s2.sensor2 = valor;
                    atualizarDisplay('s2_sensor2', sensorData.s2.sensor2);
                } else if (topic === 's2/status') {
                    sensorData.s2.status = valor;
                    atualizarDisplay('s2_status', sensorData.s2.status);
                }
                
                // Processar mensagens do Sensor 3
                else if (topic === 's3/distancia') {
                    sensorData.s3.distancia = valor;
                    atualizarDisplay('s3_distancia', sensorData.s3.distancia);
                } else if (topic === 's3/servo1') {
                    sensorData.s3.servo1 = valor;
                    atualizarDisplay('s3_servo1', sensorData.s3.servo1);
                } else if (topic === 's3/servo2') {
                    sensorData.s3.servo2 = valor;
                    atualizarDisplay('s3_servo2', sensorData.s3.servo2);
                } else if (topic === 's3/status') {
                    sensorData.s3.status = valor;
                    atualizarDisplay('s3_status', sensorData.s3.status);
                }
            });

            client.on('error', (err) => {
                console.error('Erro MQTT:', err);
                atualizarStatus(false);
            });

            client.on('close', () => {
                console.log('❌ Desconectado do MQTT');
                atualizarStatus(false);
                // Tentar reconectar após 5 segundos
                setTimeout(conectarMQTT, 5000);
            });
        }

        function atualizarStatus(conectado) {
            const indicator = document.getElementById('statusIndicator');
            const statusText = document.getElementById('statusText');
            const spinner = document.getElementById('loadingSpinner');
            
            if (conectado) {
                indicator.className = 'status-indicator status-online';
                statusText.textContent = 'Conectado ao servidor MQTT';
                spinner.style.display = 'none';
            } else {
                indicator.className = 'status-indicator status-offline';
                statusText.textContent = 'Desconectado - Tentando reconectar...';
                spinner.style.display = 'inline-block';
            }
        }

        function atualizarDisplay(elementId, valor) {
            const elemento = document.getElementById(elementId);
            if (elemento) {
                elemento.textContent = valor;
                // Animação de atualização
                elemento.style.color = '#27ae60';
                setTimeout(() => {
                    elemento.style.color = '#2c3e50';
                }, 500);
            }
        }

        function abrirModal(sensor) {
            const modal = document.getElementById(`modalSensor${sensor === 'sensor1' ? '1' : sensor === 'sensor2' ? '2' : '3'}`);
            modal.classList.add('active');
        }

        function fecharModal(sensor) {
            const modal = document.getElementById(`modalSensor${sensor === 'sensor1' ? '1' : sensor === 'sensor2' ? '2' : '3'}`);
            modal.classList.remove('active');
        }

        // Fechar modal ao clicar fora
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });

        // Iniciar conexão MQTT ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            conectarMQTT();
        });
    </script>
</body>
</html>