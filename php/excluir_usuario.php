<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    
    if ($id === 1) {
        header("Location: pessoal.php?erro=admin_protegido");
        exit;
    }
    
    $stmt = $mysqli->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: pessoal.php?sucesso=usuario_excluido");
    } else {
        header("Location: pessoal.php?erro=falha_exclusao");
    }
    
    $stmt->close();
    exit;
} else {
    header("Location: pessoal.php");
    exit;
}
?>