<?php
header('Content-Type: application/json; charset=utf-8');
include __DIR__ . '/db.php';

session_start();

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);
$data = $_POST;
if ($input && is_array($input)) {
    $data = array_merge($data, $input);
}

$email = isset($data['email']) ? trim($data['email']) : '';
$password = isset($data['password']) ? $data['password'] : '';

if ($email === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'E-mail e senha são obrigatórios.']);
    exit;
}

try {
    $stmt = $mysqli->prepare('SELECT id, name, password, email, cargo FROM usuarios WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
        exit;
    }

    $hash = $user['password'];

    $ok = false;
    if (password_verify($password, $hash)) {
        $ok = true;
    } elseif ($hash === $password) {
        $ok = true;
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $u = $mysqli->prepare('UPDATE usuarios SET password = ? WHERE id = ?');
        $u->bind_param('si', $newHash, $user['id']);
        $u->execute();
    }

    if (!$ok) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
        exit;
    }

    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'cargo' => $user['cargo']
    ];

    echo json_encode(['success' => true, 'message' => 'Autenticado com sucesso.', 'user' => $_SESSION['user']]);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro no servidor.', 'error' => $e->getMessage()]);
    exit;
}
?>