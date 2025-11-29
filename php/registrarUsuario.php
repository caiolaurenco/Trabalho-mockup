<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

include "db.php";

try {
    $conn = getPDO();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco.', 'error' => $e->getMessage()]);
    exit;
}

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);
$data = $_POST;
if ($input && is_array($input)) {
    $data = array_merge($data, $input);
}

$nome = isset($data['nome']) ? trim($data['nome']) : null;
$email = isset($data['email']) ? trim($data['email']) : null;
$senha = isset($data['senha']) ? $data['senha'] : null;

if (!$nome || !$email || !$senha) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
    exit;
}

$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
$stmt->execute([':email' => $email]);
if ($stmt->fetch()) {
    http_response_code(409);
    echo json_encode(['success' => false, 'message' => 'Email já cadastrado.']);
    exit;
}

$hash = password_hash($senha, PASSWORD_DEFAULT);

$insert = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)");
try {
    $insert->execute([':nome' => $nome, ':email' => $email, ':senha' => $hash]);
    echo json_encode(['success' => true, 'message' => 'Usuário cadastrado com sucesso.']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao inserir usuário.', 'error' => $e->getMessage()]);
}
