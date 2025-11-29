<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    
   
    header('Location: login.php');
    exit;
}

$session_timeout = 3600; 

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    session_unset();
    session_destroy();
    header('Location: login.php?erro=sessao_expirada');
    exit;
}

$_SESSION['last_activity'] = time();

function isAdmin() {
    return isset($_SESSION['user']['cargo']) && $_SESSION['user']['cargo'] === 'administrador';
}

function getLoggedUser() {
    return $_SESSION['user'] ?? null;
}
?>