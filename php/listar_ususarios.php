<?php 
header("Content-Type: application/json; charset=utf-8"); 
 
include "db.php"; 
 
try { 
    $conn = getPDO(); 
    
    // Buscar todos os usuários 
    $stmt = $conn->prepare("SELECT id, name, email, cpf, data_nasc, 
cargo, criado_em FROM usuarios ORDER BY criado_em DESC"); 
    $stmt->execute(); 
    
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    
    echo json_encode([ 
        "success" => true, 
        "usuarios" => $usuarios 
    ]); 
    
} catch (PDOException $e) { 
    http_response_code(500); 
    echo json_encode([ 
        "success" => false, 
        "message" => "Erro ao buscar usuários.", 
        "error" => $e->getMessage() 
    ]); 
} 
?>