<?php
/**
 * Script de teste de conexão com banco de dados
 * Acesse: http://localhost/php/teste_conexao.php
 */

header('Content-Type: application/json; charset=utf-8');

$resultado = [
    'timestamp' => date('Y-m-d H:i:s'),
    'testes' => []
];

// Teste 1: Verificar extensões PHP
$resultado['testes']['extensoes'] = [
    'mysqli' => extension_loaded('mysqli') ? 'OK' : 'ERRO - Não instalado',
    'pdo' => extension_loaded('pdo') ? 'OK' : 'ERRO - Não instalado',
    'pdo_mysql' => extension_loaded('pdo_mysql') ? 'OK' : 'ERRO - Não instalado'
];

// Configurações
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "root";
$DB_NAME = "mockup_db";

// Teste 2: Conexão básica MySQLi
try {
    $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS);
    
    if ($mysqli->connect_error) {
        $resultado['testes']['conexao_mysqli'] = [
            'status' => 'ERRO',
            'mensagem' => $mysqli->connect_error
        ];
    } else {
        $resultado['testes']['conexao_mysqli'] = [
            'status' => 'OK',
            'versao' => $mysqli->server_info
        ];
        
        // Teste 3: Criar banco se não existir
        $mysqli->query("CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $mysqli->select_db($DB_NAME);
        
        $resultado['testes']['criar_banco'] = [
            'status' => 'OK',
            'banco' => $DB_NAME
        ];
        
        // Teste 4: Criar tabela
        $sqlTabela = "CREATE TABLE IF NOT EXISTS usuarios (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(120) NOT NULL,
            email VARCHAR(120) NOT NULL UNIQUE,
            cpf VARCHAR(20) DEFAULT NULL,
            password VARCHAR(255) NOT NULL,
            data_nasc DATE DEFAULT NULL,
            cargo ENUM('funcionario','administrador') NOT NULL DEFAULT 'funcionario',
            ultimo_acesso DATETIME NULL,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_email (email)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        
        if ($mysqli->query($sqlTabela)) {
            $resultado['testes']['criar_tabela'] = ['status' => 'OK'];
        } else {
            $resultado['testes']['criar_tabela'] = [
                'status' => 'ERRO',
                'mensagem' => $mysqli->error
            ];
        }
        
        // Teste 5: Verificar/Criar usuário admin
        $checkAdmin = $mysqli->query("SELECT id FROM usuarios WHERE email = 'admin@gmail.com' LIMIT 1");
        
        if ($checkAdmin->num_rows === 0) {
            $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO usuarios (name, password, email, cpf, data_nasc, cargo) VALUES (?, ?, ?, ?, ?, ?)");
            $name = 'Administrador';
            $email = 'admin@gmail.com';
            $cpf = '000.000.000-00';
            $dataNasc = '2000-02-07';
            $cargo = 'administrador';
            $stmt->bind_param('ssssss', $name, $adminPassword, $email, $cpf, $dataNasc, $cargo);
            
            if ($stmt->execute()) {
                $resultado['testes']['usuario_admin'] = [
                    'status' => 'CRIADO',
                    'email' => 'admin@gmail.com',
                    'senha' => 'admin123'
                ];
            } else {
                $resultado['testes']['usuario_admin'] = [
                    'status' => 'ERRO',
                    'mensagem' => $stmt->error
                ];
            }
            $stmt->close();
        } else {
            $resultado['testes']['usuario_admin'] = [
                'status' => 'JÁ EXISTE',
                'email' => 'admin@gmail.com',
                'senha' => 'admin123'
            ];
        }
        
        // Teste 6: Contar usuários
        $count = $mysqli->query("SELECT COUNT(*) as total FROM usuarios");
        $total = $count->fetch_assoc()['total'];
        
        $resultado['testes']['total_usuarios'] = [
            'status' => 'OK',
            'quantidade' => $total
        ];
        
        // Teste 7: Listar usuários
        $users = $mysqli->query("SELECT id, name, email, cargo FROM usuarios");
        $listaUsuarios = [];
        while ($row = $users->fetch_assoc()) {
            $listaUsuarios[] = $row;
        }
        
        $resultado['testes']['lista_usuarios'] = [
            'status' => 'OK',
            'usuarios' => $listaUsuarios
        ];
        
        $mysqli->close();
    }
} catch (Exception $e) {
    $resultado['testes']['conexao_mysqli'] = [
        'status' => 'ERRO',
        'mensagem' => $e->getMessage()
    ];
}

// Teste 8: Conexão PDO
try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    $resultado['testes']['conexao_pdo'] = ['status' => 'OK'];
    
} catch (PDOException $e) {
    $resultado['testes']['conexao_pdo'] = [
        'status' => 'ERRO',
        'mensagem' => $e->getMessage()
    ];
}

// Determinar status geral
$temErro = false;
foreach ($resultado['testes'] as $teste) {
    if (is_array($teste) && isset($teste['status']) && strpos($teste['status'], 'ERRO') !== false) {
        $temErro = true;
        break;
    }
}

$resultado['status_geral'] = $temErro ? 'COM ERROS' : 'TUDO OK';

// Instruções
$resultado['instrucoes'] = [
    'login_admin' => [
        'email' => 'admin@gmail.com',
        'senha' => 'admin123'
    ],
    'proximos_passos' => [
        '1' => 'Se houver erros, verifique as credenciais do banco em db.php',
        '2' => 'Certifique-se de que o MySQL está rodando',
        '3' => 'Teste o login em: /html/login.php',
        '4' => 'Cadastre novos usuários em: /html/pessoal.php'
    ]
];

echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>