CREATE DATABASE IF NOT EXISTS mockup_db;
USE mockup_db;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    cpf VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    data_nasc DATE NOT NULL,
    cargo ENUM('funcionario','administrador') NOT NULL DEFAULT 'funcionario',
    ultimo_acesso DATETIME NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_cargo (cargo)


    CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
);

-- Inserir usuário administrador padrão
-- Senha: admin123
INSERT INTO usuarios (name, password, email, cpf, data_nasc, cargo) 
VALUES ('Administrador', 'admin123', 'admin@gmail.com', '000.000.000-00', '2000-02-07', 'administrador')
ON DUPLICATE KEY UPDATE name = name;