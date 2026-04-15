<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Lux | Cadastro</title>
    <link rel="stylesheet" href="./cadastro.css">
</head>
<body>
    <div class="cadastro-page">
        <div class="cadastro-container">
            <div class="brand-area">
                <div class="logo-area">
                    <img src="./logo-dark.png" alt="Driver Lux" class="logo-img">

                    <p class="logo-text">
                        Crie sua conta e tenha acesso à experiência exclusiva de aluguel de carros de luxo.
                    </p>
                </div>
            </div>

            <div class="cadastro-card">
                <h2>Cadastre-se</h2>
                <p class="subtitle">Preencha os dados para criar sua conta</p>

                <form action="" method="POST" class="cadastro-form">
                    <div class="input-group">
                        <label for="nome">Nome completo</label>
                        <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>
                    </div>

                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>

                    <div class="input-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" id="telefone" name="telefone" placeholder="Digite seu telefone" required>
                    </div>

                    <div class="input-group">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required>
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