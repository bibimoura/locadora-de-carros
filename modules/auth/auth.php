<?php
// modules/auth/auth.php - Funções de autenticação
require_once __DIR__ . '/../../config/database.php';

// =-=-=-=-=-=-=-=-==--=
// FAZER LOGIN
// =-=-=-=-=-=-=-=-==--=

function fazerLogin(string $email, string $senha): array {
    global $conexao;

    // validar dados
    if (empty(trim($email)) || empty($senha)) {
        throw new InvalidArgumentException('E-mail e senha são obrigatórios.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('E-mail inválido.');
    }

    // buscar o usuário no banco
    $stmt = $conexao->prepare(
        "SELECT id, nome, email, senha, tipo 
         FROM usuarios 
         WHERE email = :email AND tipo = 'cliente'"
    );
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch();

    // se não encontrou ou a senha está errada
    if (!$usuario || !password_verify($senha, $usuario['senha'])) {
        throw new RuntimeException('E-mail ou senha incorretos.');
    }

    // retorna os dados do usuário (sem a senha)
    return [
        'id'    => $usuario['id'],
        'nome'  => $usuario['nome'],
        'email' => $usuario['email'],
        'tipo'  => $usuario['tipo'],
    ];
}

// =-=-=-=-=-=-=-=-==--=
// VERIFICAR SE ESTÁ LOGADO
// =-=-=-=-=-=-=-=-==--=

function estaLogado(): bool {
    return isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id']);
}

// =-=-=-=-=-=-=-=-==--=
// OBTER DADOS DO USUÁRIO LOGADO
// =-=-=-=-=-=-=-=-==--=

function obterUsuarioLogado(): ?array {
    if (!estaLogado()) {
        return null;
    }

    global $conexao;

    $stmt = $conexao->prepare(
        "SELECT id, nome, email, tipo 
         FROM usuarios 
         WHERE id = :id"
    );
    $stmt->execute([':id' => $_SESSION['usuario_id']]);
    
    return $stmt->fetch() ?: null;
}

// =-=-=-=-=-=-=-=-==--=
// FAZER LOGOUT
// =-=-=-=-=-=-=-=-==--=

function fazerLogout(): void {
    session_destroy();
    $_SESSION = [];
}

// =-=-=-=-=-=-=-=-==--=
// REDIRECIONAR PARA LOGIN SE NÃO ESTIVER AUTENTICADO
// =-=-=-=-=-=-=-=-==--=

function verificarAutenticacao(): void {
    if (!estaLogado()) {
        header('Location: ./login.php');
        exit;
    }
}