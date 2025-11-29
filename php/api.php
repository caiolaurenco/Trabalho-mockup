<?php 
// Previne qualquer saída antes do JSON
ob_start();

// Desativa exibição de erros (mas mantém no log)
ini_set('display_errors', 0); 
ini_set('log_errors', 1);
error_reporting(E_ALL);
 
// Headers CORS e JSON
header("Content-Type: application/json; charset=utf-8"); 
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Accept"); 
 
// Responde a requisições OPTIONS (CORS preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { 
    ob_end_clean();
    http_response_code(200); 
    echo json_encode(["success" => true, "message" => "CORS OK"]);
    exit; 
} 
 
// Inclui conexão com banco
require_once __DIR__ . "/db.php"; 
 
// Tenta conectar ao banco
try { 
    $conn = getPDO(); 
} catch (Exception $e) { 
    ob_end_clean();
    http_response_code(500); 
    echo json_encode([ 
        "success" => false, 
        "message" => "Erro ao conectar ao banco de dados", 
        "error" => $e->getMessage() 
    ]); 
    exit; 
} 
 
// Lê dados JSON do corpo da requisição
$raw = file_get_contents("php://input"); 
$json = json_decode($raw, true); 
 
// Mescla dados de POST e JSON
$data = array_merge($_POST ?? [], is_array($json) ? $json : []); 
 
// Coleta e sanitiza os dados
$name       = isset($data["name"]) ? trim($data["name"]) : null; 
$email      = isset($data["email"]) ? trim($data["email"]) : null; 
$cpf        = isset($data["cpf"]) ? trim($data["cpf"]) : null; 
$password   = isset($data["password"]) ? $data["password"] : null; 
$data_nasc  = isset($data["data_nasc"]) ? $data["data_nasc"] : null; 
$cargo      = isset($data["cargo"]) ? $data["cargo"] : 'funcionario'; 
 
// Validação: campos obrigatórios
if (!$name || !$email || !$cpf || !$password || !$data_nasc) { 
    ob_end_clean();
    http_response_code(400); 
    echo json_encode([ 
        "success" => false, 
        "message" => "Dados incompletos. Campos obrigatórios: name, email, cpf, password, data_nasc" 
    ]); 
    exit; 
} 
 
// Validação: formato de e-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
    ob_end_clean();
    http_response_code(400); 
    echo json_encode([ 
        "success" => false, 
        "message" => "E-mail inválido." 
    ]); 
    exit; 
} 

// Validação: tamanho mínimo da senha
if (strlen($password) < 4) {
    ob_end_clean();
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "A senha deve ter no mínimo 4 caracteres."
    ]);
    exit;
}
 
// Verifica se e-mail já está cadastrado
try { 
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1"); 
    $stmt->execute([":email" => $email]); 
 
    if ($stmt->fetch()) { 
        ob_end_clean();
        http_response_code(409); 
        echo json_encode([ 
            "success" => false, 
            "message" => "E-mail já cadastrado." 
        ]); 
        exit; 
    } 
} catch (PDOException $e) { 
    ob_end_clean();
    http_response_code(500); 
    echo json_encode([ 
        "success" => false, 
        "message" => "Erro ao verificar e-mail", 
        "error" => $e->getMessage() 
    ]); 
    exit; 
} 
 
// Criptografa a senha
$hash = password_hash($password, PASSWORD_DEFAULT); 
 
// Prepara inserção no banco
$insert = $conn->prepare(" 
    INSERT INTO usuarios (name, email, cpf, password, data_nasc, cargo) 
    VALUES (:name, :email, :cpf, :password, :data_nasc, :cargo) 
"); 
 
// Executa inserção
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
        ob_end_clean();
        http_response_code(201); // Created
        echo json_encode([ 
            "success" => true, 
            "message" => "Usuário cadastrado com sucesso!", 
            "id" => (int)$conn->lastInsertId(),
            "user" => [
                "name" => $name,
                "email" => $email,
                "cargo" => $cargo
            ]
        ]); 
    } else { 
        ob_end_clean();
        http_response_code(500); 
        echo json_encode([ 
            "success" => false, 
            "message" => "Erro ao cadastrar usuário." 
        ]); 
    } 
 
} catch (PDOException $e) { 
    ob_end_clean();
    http_response_code(500); 
    echo json_encode([ 
        "success" => false, 
        "message" => "Erro ao inserir usuário no banco de dados.", 
        "error" => $e->getMessage() 
    ]); 
}

exit;
?>