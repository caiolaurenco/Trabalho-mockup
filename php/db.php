<?php

$DB_HOST = "localhost";
$DB_NAME = "mockup_db";
$DB_USER = "root";
$DB_PASS = "root";
$DB_CHARSET = "utf8mb4";

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
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erro ao conectar ao banco"]);
        exit;
    }

    return $pdo;
}
