<?php
// pages/home.php - Página inicial após login
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../modules/auth/auth.php';
require_once __DIR__ . '/../modules/carro/carro.php';

session_start();

// Verifica se está autenticado
verificarAutenticacao();

// Obtém dados do usuário logado
$usuario = obterUsuarioLogado();

// Obtém lista de carros disponíveis
try {
    $carros = listarCarros();
} catch (Exception $e) {
    $carros = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Lux | Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #fff;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.9);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #d4af37;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #d4af37;
            letter-spacing: 2px;
        }

        .navbar .user-menu {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .navbar .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .navbar .user-info p {
            font-size: 0.9rem;
            color: #bbb;
        }

        .navbar .user-info strong {
            color: #d4af37;
        }

        .navbar .logout-btn {
            background: #d4af37;
            color: #1a1a1a;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .navbar .logout-btn:hover {
            background: #fff;
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        .welcome-section {
            background: rgba(212, 175, 55, 0.1);
            border-left: 4px solid #d4af37;
            padding: 2rem;
            margin-bottom: 3rem;
            border-radius: 8px;
        }

        .welcome-section h1 {
            color: #d4af37;
            margin-bottom: 0.5rem;
        }

        .welcome-section p {
            color: #ccc;
            font-size: 1.1rem;
        }

        .cars-section h2 {
            color: #d4af37;
            margin-bottom: 2rem;
            font-size: 2rem;
            text-align: center;
        }

        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .car-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid #d4af37;
            border-radius: 8px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .car-card:hover {
            background: rgba(212, 175, 55, 0.15);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
        }

        .car-card h3 {
            color: #d4af37;
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .car-card p {
            color: #bbb;
            margin: 0.5rem 0;
            font-size: 0.95rem;
        }

        .car-info {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #d4af37;
        }

        .car-price {
            color: #d4af37;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .car-status {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-disponivel {
            background: rgba(124, 252, 152, 0.2);
            color: #7cfc98;
        }

        .status-alugado {
            background: rgba(255, 107, 107, 0.2);
            color: #ff6b6b;
        }

        .status-manutencao {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .rent-btn {
            width: 100%;
            background: #d4af37;
            color: #1a1a1a;
            border: none;
            padding: 0.8rem;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }

        .rent-btn:hover:not(:disabled) {
            background: #fff;
            transform: scale(1.02);
        }

        .rent-btn:disabled {
            background: #666;
            cursor: not-allowed;
            color: #999;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #bbb;
        }

        .empty-state p {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">🏎️ Driver Lux</div>
        <div class="user-menu">
            <div class="user-info">
                <p>Bem-vindo,</p>
                <strong><?= htmlspecialchars($usuario['nome']) ?></strong>
            </div>
            <form action="logout.php" method="POST" style="margin: 0;">
                <button type="submit" class="logout-btn">Sair</button>
            </form>
        </div>
    </nav>

    <!-- Container -->
    <div class="container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1>Bem-vindo ao Driver Lux</h1>
            <p>Escolha o seu carro de luxo ideal e aproveite uma experiência única de aluguel.</p>
        </div>

        <!-- Cars Section -->
        <section class="cars-section">
            <h2>🚗 Frota de Veículos</h2>

            <?php if (empty($carros)): ?>
                <div class="empty-state">
                    <p>Nenhum carro disponível no momento.</p>
                </div>
            <?php else: ?>
                <div class="cars-grid">
                    <?php foreach ($carros as $carro): ?>
                        <div class="car-card">
                            <h3><?= htmlspecialchars($carro['marca']) ?> <?= htmlspecialchars($carro['modelo']) ?></h3>
                            
                            <p>
                                <strong>Ano:</strong> <?= $carro['ano'] ?>
                            </p>
                            <p>
                                <strong>Placa:</strong> <?= htmlspecialchars($carro['placa']) ?>
                            </p>

                            <div class="car-info">
                                <div class="car-price">
                                    R$ <?= number_format($carro['valor_diaria'], 2, ',', '.') ?>/dia
                                </div>
                                <span class="car-status status-<?= $carro['status'] ?>">
                                    <?= ucfirst($carro['status']) ?>
                                </span>
                            </div>

                            <button 
                                class="rent-btn" 
                                <?php if ($carro['status'] !== 'disponivel'): ?>disabled<?php endif; ?>
                            >
                                <?php if ($carro['status'] === 'disponivel'): ?>
                                    Alugar Agora
                                <?php else: ?>
                                    Indisponível
                                <?php endif; ?>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>