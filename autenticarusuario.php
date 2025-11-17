<?php
header('Content-Type: application/json; charset=utf-8');
include _DIR_ . '/db.php';

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
    $stmt = $conn->prepare('SELECT id, name, password, email, cargo FROM usuarios WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

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
        $u = $conn->prepare('UPDATE usuarios SET password = :p WHERE id = :id');
        $u->execute([':p' => $newHash, ':id' => $user['id']]);
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

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro no servidor.', 'error' => $e->getMessage()]);
    exit;
}

?>