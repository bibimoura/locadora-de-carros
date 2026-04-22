<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../modules/carro/carro.php';

session_start();

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = trim($_POST['marca'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $ano = (int) ($_POST['ano'] ?? 0);
    $placa = trim($_POST['placa'] ?? '');
    $valor_diaria = (float) ($_POST['valor_diaria'] ?? 0);
    $status = $_POST['status'] ?? 'disponivel';
    
    try {
    $url_foto = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {

        $pasta = __DIR__ . '/../uploads/';
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $nomeArquivo = uniqid() . '_' . $_FILES['foto']['name'];
        $caminhoCompleto = $pasta . $nomeArquivo;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoCompleto)) {
            $url_foto = 'uploads/' . $nomeArquivo;
        } else {
            throw new RuntimeException('Erro ao fazer upload da imagem.');
        }
    }

    criarCarro($marca, $modelo, $ano, $placa, $valor_diaria, $status, $url_foto);

    $sucesso = 'Carro cadastrado com sucesso!';
    $_POST = [];

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
    <title>Driver Lux | Cadastro de Carros</title>
    <link rel="stylesheet" href="style/cadastro_carro.css">
</head>
<body>
<div class="cadastro-page">
    <div class="cadastro-container">

        <div class="cadastro-card">
            <h2>Cadastrar Carro</h2>
            <p class="subtitle">Preencha os dados do veículo</p>

            <?php if (!empty($erro)): ?>
                <p style="color: #ff6b6b;"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>

            <?php if (!empty($sucesso)): ?>
                <p style="color: #7CFC98;"><?= htmlspecialchars($sucesso) ?></p>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="cadastro-form">

                <div class="input-group">
                    <label>Marca</label>
                    <input type="text" name="marca" required
                        value="<?= htmlspecialchars($_POST['marca'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <label>Modelo</label>
                    <input type="text" name="modelo" required
                        value="<?= htmlspecialchars($_POST['modelo'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <label>Ano</label>
                    <input type="number" name="ano" required
                        value="<?= htmlspecialchars($_POST['ano'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <label>Placa</label>
                    <input type="text" name="placa" required
                        value="<?= htmlspecialchars($_POST['placa'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <label>Valor da diária (R$)</label>
                    <input type="number" step="0.01" name="valor_diaria" required
                        value="<?= htmlspecialchars($_POST['valor_diaria'] ?? '') ?>">
                </div>

                <div class="input-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="disponivel">Disponível</option>
                        <option value="alugado">Alugado</option>
                        <option value="manutencao">Manutenção</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Foto do carro</label>
                    <input type="file" name="foto" accept="image/*">
                </div>

                <button type="submit" class="btn-cadastro">Cadastrar Carro</button>
            </form>
        </div>

    </div>
</div>
</body>
</html>