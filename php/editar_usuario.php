<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();
require_once __DIR__ . '/db.php';

// Processar dados
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data) {
    $data = $_POST;
}

// Validar ID
$id = isset($data['id']) ? (int)$data['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'ID inválido'
    ]);
    exit;
}

// Campos para atualizar
$name = isset($data['name']) ? trim($data['name']) : null;
$email = isset($data['email']) ? trim($data['email']) : null;
$cpf = isset($data['cpf']) ? trim($data['cpf']) : null;
$data_nasc = isset($data['data_nasc']) ? $data['data_nasc'] : null;
$cargo = isset($data['cargo']) ? $data['cargo'] : null;
$password = isset($data['password']) ? trim($data['password']) : null;

// Validações
if (!$name || !$email) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Nome e email são obrigatórios'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Email inválido'
    ]);
    exit;
}

try {
    // Verificar se o email já existe em outro usuário
    $stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ? LIMIT 1");
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'message' => 'Este email já está sendo usado por outro usuário'
        ]);
        exit;
    }
    $stmt->close();
    
    // Buscar email original antes da atualização
    $stmtOriginal = $mysqli->prepare("SELECT email FROM usuarios WHERE id = ? LIMIT 1");
    $stmtOriginal->bind_param("i", $id);
    $stmtOriginal->execute();
    $resultOriginal = $stmtOriginal->get_result();
    $originalEmail = $resultOriginal->fetch_assoc()['email'] ?? null;
    $stmtOriginal->close();
    
    // Montar query de atualização
    if (!empty($password)) {
        // Atualizar com nova senha
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $update = $mysqli->prepare("
            UPDATE usuarios 
            SET name = ?, email = ?, cpf = ?, data_nasc = ?, cargo = ?, password = ?
            WHERE id = ?
        ");
        $update->bind_param("ssssssi", $name, $email, $cpf, $data_nasc, $cargo, $hash, $id);
    } else {
        // Atualizar sem modificar senha
        $update = $mysqli->prepare("
            UPDATE usuarios 
            SET name = ?, email = ?, cpf = ?, data_nasc = ?, cargo = ?
            WHERE id = ?
        ");
        $update->bind_param("sssssi", $name, $email, $cpf, $data_nasc, $cargo, $id);
    }
    
    if ($update->execute()) {
        // Buscar dados atualizados
        $stmt = $mysqli->prepare("SELECT id, name, email, cpf, data_nasc, cargo FROM usuarios WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();
        
        echo json_encode([
            'success' => true,
            'message' => 'Usuário atualizado com sucesso',
            'user' => $usuario,
            'originalEmail' => $originalEmail
        ]);
    } else {
        throw new Exception("Erro ao executar atualização: " . $mysqli->error);
    }
    
    $update->close();
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao atualizar usuário',
        'error' => $e->getMessage()
    ]);
}

$mysqli->close();
?>