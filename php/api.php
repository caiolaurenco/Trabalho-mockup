<<<<<<< HEAD
<?php 
ini_set('display_errors', 1); 
error_reporting(E_ALL); 
 
header("Content-Type: application/json; charset=utf-8"); 
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type"); 
 
// Se for OPTIONS, retorna OK (CORS preflight) 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { 
    http_response_code(200); 
    exit; 
} 
 
include "db.php"; 
 
try { 
    $conn = getPDO(); 
} catch (Exception $e) { 
    http_response_code(500); 
    echo json_encode([ 
        "success" => false, 
        "message" => "Erro ao conectar ao banco de dados", 
        "error" => $e->getMessage() 
    ]); 
    exit; 
} 
 
// Lê JSON ou POST 
$raw = file_get_contents("php://input"); 
$json = json_decode($raw, true); 
 
$data = array_merge($_POST ?? [], is_array($json) ? $json : []); 
 
// Coleta dados do JSON/POST 
$name       = isset($data["name"]) ? trim($data["name"]) : null; 
$email      = isset($data["email"]) ? trim($data["email"]) : null; 
$cpf        = isset($data["cpf"]) ? trim($data["cpf"]) : null; 
$password   = isset($data["password"]) ? $data["password"] : null; 
$data_nasc  = isset($data["data_nasc"]) ? $data["data_nasc"] : null; 
$cargo      = isset($data["cargo"]) ? $data["cargo"] : 'funcionario'; 
 
// Campos obrigatórios do banco 
if (!$name || !$email || !$cpf || !$password || !$data_nasc) { 
    http_response_code(400); 
    echo json_encode([ 
        "success" => false, 
        "message" => "Dados incompletos. Campos obrigatórios: name, 
email, cpf, password, data_nasc" 
    ]); 
    exit; 
} 
 
// Validar e-mail 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
    http_response_code(400); 
    echo json_encode([ 
        "success" => false, 
        "message" => "E-mail inválido." 
    ]); 
    exit; 
} 
 
// Verifica duplicidade de e-mail 
try { 
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = 
:email LIMIT 1"); 
    $stmt->execute([":email" => $email]); 
 
    if ($stmt->fetch()) { 
        http_response_code(409); 
        echo json_encode([ 
            "success" => false, 
            "message" => "E-mail já cadastrado." 
        ]); 
        exit; 
    } 
} catch (PDOException $e) { 
    http_response_code(500); 
    echo json_encode([ 
        "success" => false, 
        "message" => "Erro ao verificar e-mail", 
        "error" => $e->getMessage() 
    ]); 
    exit; 
} 
 
// Criptografa senha 
$hash = password_hash($password, PASSWORD_DEFAULT); 
 
// Inserção no banco 
$insert = $conn->prepare(" 
    INSERT INTO usuarios (name, email, cpf, password, data_nasc, cargo) 
    VALUES (:name, :email, :cpf, :password, :data_nasc, :cargo) 
"); 
 
try { 
    $resultado = $insert->execute([ 
        ":name"      => $name, 
        ":email"     => $email, 
        ":cpf"       => $cpf, 
        ":password"  => $hash, 
        ":data_nasc" => $data_nasc, 
        ":cargo"     => $cargo 
    ]); 
 
    if ($resultado) { 
        echo json_encode([ 
            "success" => true, 
            "message" => "Usuário cadastrado com sucesso!", 
            "id" => $conn->lastInsertId() 
        ]); 
    } else { 
        http_response_code(500); 
        echo json_encode([ 
            "success" => false, 
            "message" => "Erro ao cadastrar usuário." 
        ]); 
    } 
 
} catch (PDOException $e) { 
    http_response_code(500); 
    echo json_encode([ 
        "success" => false, 
        "message" => "Erro ao inserir usuário no banco de dados.", 
        "error" => $e->getMessage() 
    ]); 
} 
?> 
=======
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=utf-8");

include "db.php";
$conn = getPDO();

$raw = file_get_contents("php://input");
$json = json_decode($raw, true);

$data = array_merge($_POST ?? [], is_array($json) ? $json : []);

$name       = isset($data["name"]) ? trim($data["name"]) : null;
$email      = isset($data["email"]) ? trim($data["email"]) : null;
$cpf        = isset($data["cpf"]) ? trim($data["cpf"]) : null;
$password   = isset($data["password"]) ? $data["password"] : null;
$data_nasc  = isset($data["data_nasc"]) ? $data["data_nasc"] : null;


if (!$name || !$email || !$cpf || !$password || !$data_nasc) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Dados incompletos. Campos obrigatórios: name, email, cpf, password, data_nasc"
    ]);
    exit;
}

$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
$stmt->execute([":email" => $email]);

if ($stmt->fetch()) {
    http_response_code(409);
    echo json_encode([
        "success" => false,
        "message" => "Email já cadastrado."
    ]);
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$insert = $conn->prepare("
    INSERT INTO usuarios (name, email, cpf, password, data_nasc)
    VALUES (:name, :email, :cpf, :password, :data_nasc)
");

try {
    $insert->execute([
        ":name"      => $name,
        ":email"     => $email,
        ":cpf"       => $cpf,
        ":password"  => $hash,
        ":data_nasc" => $data_nasc
    ]);

    echo json_encode(["success" => true, "message" => "Usuário cadastrado com sucesso."]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Erro ao inserir usuário.",
        "error"   => $e->getMessage()
    ]);
}
>>>>>>> 060495b88f50316748d67bfb534cbe527ae02d46
