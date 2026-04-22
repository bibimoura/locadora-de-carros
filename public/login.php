<?php
// pages/login.php - Página de login para clientes
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../modules/auth/auth.php';

session_start();

// Se já está logado, redireciona para home
if (estaLogado()) {
    header('Location: ./home.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    try {
        // Faz o login
        $usuario = fazerLogin($email, $senha);

        // Salva na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];

        // Redireciona para home
        header('Location: ./home.php');
        exit;

    } catch (Throwable $e) {
        $erro = $e->getMessage();
    }
}
?>


<?php
// login.php
require_once __DIR__ . '/../includes/auth.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (realizarLogin($email, $senha)) {
        header('Location: index.php'); 
        exit;
    } else {
        $erro = 'E-mail ou senha incorretos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Lux | Login</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <div class="login-page">
        <div class="overlay"></div>

        <div class="login-container">
            <div class="brand-area">
                <div class="logo-area">
                    <img src="image/logo-dark.png" alt="Driver Lux" class="logo-img">

                    <p class="logo-text">
                        Aluguel de carros de luxo com sofisticação, conforto e exclusividade.
                    </p>
                </div>
            </div>

            <div class="login-card">
                <h2>Entrar</h2>
                <p class="subtitle">Acesse sua conta para continuar</p>

                <?php if (!empty($erro)): ?>
                    <p style="color: #ff6b6b; margin-bottom: 15px;">
                        ⚠️ <?= htmlspecialchars($erro) ?>
                    </p>
                <?php endif; ?>

                <form action="" method="POST" class="login-form">
                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="Digite seu e-mail"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            required
                        >
                    </div>

                    <div class="input-group">
                        <label for="senha">Senha</label>
                        <input 
                            type="password" 
                            id="senha" 
                            name="senha" 
                            placeholder="Digite sua senha" 
                            required
                        >
                    </div>

                    <div class="form-options">
                        <label class="remember">
                            <input type="checkbox" name="lembrar">
                            Lembrar-me
                        </label>
                        <a href="#" class="forgot-password">Esqueci minha senha</a>
                    </div>

                    <button type="submit" class="btn-login">Entrar</button>
                </form>

                <p class="register-link">
                    Não tem conta? <a href="./cadastro.php">Cadastre-se</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>