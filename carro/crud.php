<?php

// ============================================================
//  CRUD - Carro
//  Assumindo que a conexão PDO vem de fora ($pdo já existe)
// ============================================================

// ---------- CREATE ----------
function criarCarro(PDO $pdo, array $dados): int|false
{
    $sql = "INSERT INTO carros (marca, modelo, ano, cor, placa, preco)
            VALUES (:marca, :modelo, :ano, :cor, :placa, :preco)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':marca',  $dados['marca']);
    $stmt->bindValue(':modelo', $dados['modelo']);
    $stmt->bindValue(':ano',    $dados['ano'],    PDO::PARAM_INT);
    $stmt->bindValue(':cor',    $dados['cor']);
    $stmt->bindValue(':placa',  $dados['placa']);
    $stmt->bindValue(':preco',  $dados['preco']);

    if ($stmt->execute()) {
        return (int) $pdo->lastInsertId();
    }

    return false;
}

// ---------- READ (todos) ----------
function listarCarros(PDO $pdo): array
{
    $stmt = $pdo->query("SELECT * FROM carros ORDER BY id ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ---------- READ (um) ----------
function buscarCarro(PDO $pdo, int $id): array|false
{
    $stmt = $pdo->prepare("SELECT * FROM carros WHERE id = :id LIMIT 1");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ---------- UPDATE ----------
function atualizarCarro(PDO $pdo, int $id, array $dados): bool
{
    $sql = "UPDATE carros
            SET marca  = :marca,
                modelo = :modelo,
                ano    = :ano,
                cor    = :cor,
                placa  = :placa,
                preco  = :preco
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':marca',  $dados['marca']);
    $stmt->bindValue(':modelo', $dados['modelo']);
    $stmt->bindValue(':ano',    $dados['ano'],    PDO::PARAM_INT);
    $stmt->bindValue(':cor',    $dados['cor']);
    $stmt->bindValue(':placa',  $dados['placa']);
    $stmt->bindValue(':preco',  $dados['preco']);
    $stmt->bindValue(':id',     $id,              PDO::PARAM_INT);

    return $stmt->execute();
}

// ---------- DELETE ----------
function deletarCarro(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare("DELETE FROM carros WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}


// ============================================================
//  EXEMPLOS DE USO
// ============================================================

/*

// -- Criar --
$novoId = criarCarro($pdo, [
    'marca'  => 'Toyota',
    'modelo' => 'Corolla',
    'ano'    => 2022,
    'cor'    => 'Prata',
    'placa'  => 'ABC-1234',
    'preco'  => 95000.00,
]);
echo "Carro criado com ID: $novoId";

// -- Listar todos --
$carros = listarCarros($pdo);
foreach ($carros as $carro) {
    echo $carro['marca'] . ' ' . $carro['modelo'] . PHP_EOL;
}

// -- Buscar um --
$carro = buscarCarro($pdo, 1);
if ($carro) {
    echo $carro['modelo'];
} else {
    echo "Carro não encontrado.";
}

// -- Atualizar --
$ok = atualizarCarro($pdo, 1, [
    'marca'  => 'Honda',
    'modelo' => 'Civic',
    'ano'    => 2023,
    'cor'    => 'Preto',
    'placa'  => 'XYZ-5678',
    'preco'  => 110000.00,
]);
echo $ok ? "Atualizado!" : "Erro ao atualizar.";

// -- Deletar --
$ok = deletarCarro($pdo, 1);
echo $ok ? "Deletado!" : "Erro ao deletar.";

*/