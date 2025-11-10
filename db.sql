create database mockup_db;
use mockup_db;

create table usuarios (
    id int primary key auto_increment,
    name varchar(120) not null,
    email varchar(120) not null,
    cpf varchar(20) not null,
    password varchar(255) not null,
    data_nasc date not null,
    cargo enum('funcionario','administrador') not null    
);

INSERT INTO usuarios (name, password, email, cpf, data_nasc, cargo) VALUES ('admin','admin123', 'admin@gmail.com', '000.000.000-00', '2000-002-07', 'administrador');