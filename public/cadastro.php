<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../modules/cliente/cliente.php';
session_start();

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    try {
        if ($senha !== $confirmarSenha) {
            throw new InvalidArgumentException('As senhas não coincidem.');
        }

        criarCliente($nome, $email, $senha);

        $sucesso = 'Cadastro realizado com sucesso!';

        // opcional: limpar os campos após cadastrar
        $_POST = [];

        // se quiser redirecionar para login, use isso no lugar da mensagem:
        // header('Location: ./login.php');
        // exit;

    } catch (Throwable $e) {
        $erro = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Lux | Cadastro</title>
    <link rel="stylesheet" href="style/cadastro.css">
</head>
<body>
    <div class="cadastro-page">
        <div class="cadastro-container">
            <div class="brand-area">
                <div class="logo-area">
                    <img src="image/logo-dark.png" alt="Driver Lux" class="logo-img">

                    <p class="logo-text">
                        Crie sua conta e tenha acesso à experiência exclusiva de aluguel de carros de luxo.
                    </p>
                </div>
            </div>

            <div class="cadastro-card">
                <h2>Cadastre-se</h2>
                <p class="subtitle">Preencha os dados para criar sua conta</p>

                <?php if (!empty($erro)): ?>
                    <p style="color: #ff6b6b; margin-bottom: 15px;">
                        <?= htmlspecialchars($erro) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($sucesso)): ?>
                    <p style="color: #7CFC98; margin-bottom: 15px;">
                        <?= htmlspecialchars($sucesso) ?>
                    </p>
                <?php endif; ?>

                <form action="" method="POST" class="cadastro-form">
                    <div class="input-group">
                        <label for="nome">Nome completo</label>
                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            placeholder="Digite seu nome completo"
                            value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                            required
                        >
                    </div>

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
                        <input type="password" id="senha" name="senha" placeholder="Crie uma senha" required>
                    </div>

                    <div class="input-group">
                        <label for="confirmar_senha">Confirmar senha</label>
                        <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua senha" required>
                    </div>

                    <button type="submit" class="btn-cadastro">Cadastrar</button>
                </form>

                <p class="login-link">
                    Já tem conta? <a href="./login.php">Entrar</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>