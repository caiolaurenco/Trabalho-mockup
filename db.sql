create database mockup_db;
use mockup_db;

create table usuarios (
    id int primary key auto_increment,
    name varchar(120) not null,
    email varchar(120) not null,
    cpf varchar(20) not null,
    password varchar(255) not null,
    data_nasc date not null,
    cargo enum('funcionario','adm') not null    
);

