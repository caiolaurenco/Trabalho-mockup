<?php
// ...existing code...

// Configurações de conexão
$DB_HOST = 'localhost';
$DB_NAME = 'mockup_db';
$DB_USER = 'root';
$DB_PASS = '';
$DB_CHARSET = 'utf8mb4';

// MySQLi (usado pela maioria dos seus scripts)
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("Erro de conexão MySQLi: " . $mysqli->connect_error);
}
$mysqli->set_charset($DB_CHARSET);
