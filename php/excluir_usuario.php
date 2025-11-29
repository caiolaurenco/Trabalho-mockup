<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

<<<<<<< HEAD
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

// Proteger usuário admin padrão
if ($id === 1) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'O usuário administrador padrão não pode ser excluído'
    ]);
    exit;
}

try {
    // Verificar se usuário existe
    $check = $mysqli->prepare("SELECT name FROM usuarios WHERE id = ? LIMIT 1");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Usuário não encontrado'
        ]);
        exit;
    }
    
    $user = $result->fetch_assoc();
    $check->close();
=======
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    
    if ($id === 1) {
        header("Location: pessoal.php?erro=admin_protegido");
        exit;
    }
    
    $stmt = $mysqli->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
>>>>>>> 060495b88f50316748d67bfb534cbe527ae02d46
    
    // Excluir usuário
    $delete = $mysqli->prepare("DELETE FROM usuarios WHERE id = ?");
    $delete->bind_param("i", $id);
    
    if ($delete->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Usuário excluído com sucesso',
            'deleted_user' => $user['name']
        ]);
    } else {
        throw new Exception("Erro ao executar exclusão: " . $mysqli->error);
    }
    
    $delete->close();
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao excluir usuário',
        'error' => $e->getMessage()
    ]);
}

$mysqli->close();
?>