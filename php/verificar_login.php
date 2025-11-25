<?php
// verificar_login.php
// Incluir este arquivo no topo de todas as páginas que precisam de autenticação

session_start();

// Verificar se usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Salvar URL atual para redirecionamento após login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    
    // Redirecionar para página de login
    header('Location: login.php');
    exit;
}

// Verificar se a sessão ainda é válida (opcional - timeout de sessão)
$session_timeout = 3600; // 1 hora em segundos

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // Sessão expirada
    session_unset();
    session_destroy();
    header('Location: login.php?erro=sessao_expirada');
    exit;
}

// Atualizar último momento de atividade
$_SESSION['last_activity'] = time();

// Função para verificar se usuário é administrador
function isAdmin() {
    return isset($_SESSION['user']['cargo']) && $_SESSION['user']['cargo'] === 'administrador';
}

// Função para obter dados do usuário logado
function getLoggedUser() {
    return $_SESSION['user'] ?? null;
}
?>