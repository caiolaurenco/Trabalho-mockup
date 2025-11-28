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

// Validação básica
if ($email === '' || $password === '') {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => 'E-mail e senha são obrigatórios.'
    ]);
    exit;
}

// Validar formato do email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => 'E-mail inválido.'
    ]);
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
        echo json_encode([
            'success' => false, 
            'message' => 'E-mail ou senha incorretos.'
        ]);
        exit;
    }

    $hash = $user['password'];
    $authenticated = false;

    if (password_verify($password, $hash)) {
        $authenticated = true;
    } 
    elseif ($hash === $password) {
        $authenticated = true;
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $u = $mysqli->prepare('UPDATE usuarios SET password = ? WHERE id = ?');
        $u->bind_param('si', $newHash, $user['id']);
        $u->execute();
    }

    if (!$authenticated) {
        http_response_code(401);
        echo json_encode([
            'success' => false, 
            'message' => 'E-mail ou senha incorretos.'
        ]);
        exit;
    }

    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'cargo' => $user['cargo']
    ];

    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user['id'];

    $updateAccess = $mysqli->prepare('UPDATE usuarios SET ultimo_acesso = NOW() WHERE id = ?');
    if ($updateAccess) {
        $updateAccess->bind_param('i', $user['id']);
        $updateAccess->execute();
    }

    echo json_encode([
        'success' => true, 
        'message' => 'Login realizado com sucesso.', 
        'user' => [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'cargo' => $user['cargo']
        ]
    ]);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Erro no servidor. Tente novamente.', 
        'error' => $e->getMessage()
    ]);
    exit;
}
?>