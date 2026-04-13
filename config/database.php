<?php
// Configurações do Banco de Dados da Locadora
$host = 'localhost';
$db   = 'locadora_carros';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opções de configuração do PDO
$opcoes = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lança exceções se der erro
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna os dados do banco como um array limpo
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desativa a emulação para máxima segurança
];

// Tentando conectar
try {
    $conexao = new PDO($dsn, $user, $pass, $opcoes);
} catch (\PDOException $e) {
    // Se der erro, ele para tudo e avisa
    die("A conexão falhou: " . $e->getMessage());
}
?>