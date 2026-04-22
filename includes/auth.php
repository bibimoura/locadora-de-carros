<?php
require_once __DIR__ . '/../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function realizarLogin(string $email, string $senha): bool {
    global $conexao;

    // Busca o usuário pelo e-mail
    $stmt = $conexao->prepare("SELECT id, nome, senha, tipo FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => trim($email)]);
    $usuario = $stmt->fetch();

    // Verifica se o usuário existe
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Sucesso! Grava os dados essenciais na sessão
        $_SESSION['usuario_id']   = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
        
        return true;
    }

    return false;
}

/**
 * Verifica se o usuário está logado. 
 * Coloque essa função no topo de páginas protegidas (ex: painel.php).
 */
function protegerPagina(): void {
    if (!isset($_SESSION['usuario_id'])) {
        // Se não tiver ID na sessão, expulsa para o login
        header('Location: ../login.php');
        exit;
    }
}

/**
 * Destrói a sessão e desloga o usuário
 */
function realizarLogout(): void {
    session_start();
    session_unset();
    session_destroy();
    header('Location: ../public/login.php');
    exit;
}
?>