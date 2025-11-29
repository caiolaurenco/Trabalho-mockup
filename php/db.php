<?php
// Configurações do Banco de Dados
$DB_HOST = "localhost";
$DB_NAME = "mockup_db";
$DB_USER = "root";
$DB_PASS = "";
$DB_CHARSET = "utf8mb4";

// Conexão MySQLi Global
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($mysqli->connect_error) {
    die(json_encode([
        "success" => false, 
        "message" => "Erro de conexão: " . $mysqli->connect_error
    ]));
}

$mysqli->set_charset($DB_CHARSET);

// Função PDO (mantida para compatibilidade)
function getPDO() {
    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_CHARSET;
    
    static $pdo = null;
    if ($pdo !== null) return $pdo;
    
    try {
        $pdo = new PDO(
            "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=$DB_CHARSET",
            $DB_USER,
            $DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    } catch (PDOException $e) {
        die(json_encode([
            "success" => false, 
            "message" => "Erro ao conectar ao banco: " . $e->getMessage()
        ]));
    }
    
    return $pdo;
}

// Função para verificar se o banco existe e criar se necessário
function verificarECriarBanco() {
    global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME;
    
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS);
    
    if ($conn->connect_error) {
        return false;
    }
    
    // Criar banco se não existir
    $conn->query("CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conn->select_db($DB_NAME);
    
    // Criar tabela de usuários se não existir
    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(120) NOT NULL,
        email VARCHAR(120) NOT NULL UNIQUE,
        cpf VARCHAR(20) DEFAULT NULL,
        password VARCHAR(255) NOT NULL,
        data_nasc DATE DEFAULT NULL,
        cargo ENUM('funcionario','administrador') NOT NULL DEFAULT 'funcionario',
        ultimo_acesso DATETIME NULL,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_email (email),
        INDEX idx_cargo (cargo)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->query($sql);
    
    // Criar usuário admin padrão se não existir
    $checkAdmin = $conn->query("SELECT id FROM usuarios WHERE email = 'admin@gmail.com' LIMIT 1");
    if ($checkAdmin->num_rows === 0) {
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuarios (name, password, email, cpf, data_nasc, cargo) VALUES (?, ?, ?, ?, ?, ?)");
        $name = 'Administrador';
        $email = 'admin@gmail.com';
        $cpf = '000.000.000-00';
        $dataNasc = '2000-02-07';
        $cargo = 'administrador';
        $stmt->bind_param('ssssss', $name, $adminPassword, $email, $cpf, $dataNasc, $cargo);
        $stmt->execute();
    }
    
    $conn->close();
    return true;
}

// Executar verificação ao incluir o arquivo
verificarECriarBanco();
?>