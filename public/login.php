<?php
// login.php - Página de login para clientes
require_once __DIR__ . '/../config/database.php';
//login.php
session_start();
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

                <form action="" method="POST" class="login-form">
                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>

                    <div class="input-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
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