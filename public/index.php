<?php
// index.php
require_once '../includes/auth.php'; // Caminho para o arquivo que criamos

// Se o usuário não estiver logado, ele será mandado de volta para o login
protegerPagina(); 

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Driver Lux | Home</title>
</head>
<body>
    <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</h1>
    <p>Se você está vendo esta página, a **permanência (sessão)** funcionou perfeitamente.</p>
    <p>Seu cargo atual é: <strong><?= htmlspecialchars($_SESSION['usuario_tipo']) ?></strong></p>
    
    <hr>
    <a href="../includes/logout.php">Sair do Sistema</a>
</body>
</html>