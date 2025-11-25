<?php
class Auth {
    public function __construct(){ if(session_status()===PHP_SESSION_NONE) session_start(); }

    public function isLoggedIn(){
        return isset($_SESSION['user_id']);
    }

    public function loginUser(array $user){
        $_SESSION['user_id'] = $user['id'] ?? $user['id_usuario'] ?? null;
        $_SESSION['username'] = $user['name'] ?? $user['nome'] ?? null;
        $_SESSION['email'] = $user['email'] ?? null;
        $_SESSION['funcao'] = $user['cargo'] ?? $user['funcao'] ?? null;
    }

    public function logout(){
        if(session_status()===PHP_SESSION_ACTIVE){ session_unset(); session_destroy(); }
        header('Location: index.php');
        exit;
    }
}

?>