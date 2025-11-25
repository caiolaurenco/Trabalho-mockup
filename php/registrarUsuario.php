<?php
header('Content-Type: application/json; charset=utf-8');


include "db.php";

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);
$data = $_POST;
if ($input && is_array($input)) {
    $data = array_merge($data, $input);
}

$name = isset($data['name']) ? trim($data['name']) : '';
$email = isset($data['email']) ? trim($data['email']) : '';
$password = isset($data['password']) ? $data['password'] : '';
$cpf = isset($data['cpf']) ? trim($data['cpf']) : '';
$data_nasc = isset($data['data_nasc']) ? trim($data['data_nasc']) : null;
$cargo = isset($data['cargo']) ? trim($data['cargo']) : 'funcionario';

$errors = [];
if ($name === '') $errors[] = 'Nome é obrigatório.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'E-mail inválido.';
if ($password === '' || strlen($password) < 4) $errors[] = 'Senha inválida (mínimo 4 caracteres).';

if (count($errors) > 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

try {
    $stmt = $conn->prepare('SELECT id FROM usuarios WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'E-mail já cadastrado.']);
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $insert = $conn->prepare('INSERT INTO usuarios (name, password, email, cpf, data_nasc, cargo) VALUES (:name, :password, :email, :cpf, :data_nasc, :cargo)');
    $insert->execute([
        ':name' => $name,
        ':password' => $hash,
        ':email' => $email,
        ':cpf' => $cpf,
        ':data_nasc' => $data_nasc,
        ':cargo' => $cargo
    ]);

    $id = $conn->lastInsertId();
    http_response_code(201);
    echo json_encode(['success' => true, 'message' => 'Usuário criado com sucesso.', 'id' => $id]);
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro no servidor.', 'error' => $e->getMessage()]);
    exit;
}

?>