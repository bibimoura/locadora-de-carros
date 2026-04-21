<?php

require_once __DIR__ . '/../../config/database.php';


// =-=-=-=-=-=-=-=-==--=
// LISTAR carros
// =-=-=-=-=-=-=-=-==--=

function listarCarros(): array {
    global $conexao;
    // percorre todos os resultados e retorna tudo de uma vez
    $stmt = $conexao->query(
        "SELECT id, marca, modelo, ano, placa, url_foto, valor_diaria, status, criado_em
         FROM carros
         ORDER BY id ASC"
    );
    return $stmt->fetchAll();
}

// =-=-=-=-=-=-=-=-==--=
// CRIAR um novo carro 
// =-=-=-=-=-=-=-=-==--=

function criarCarro( string $marca, string $modelo, int $ano, string $placa, float $valor_diaria, string $status = 'disponivel', ?string $url_foto = null): array {
    global $conexao;

    // verificar os dados do novo carro
    validarDadosCarro($marca, $modelo, $ano, $placa, $valor_diaria, $status, $url_foto);

    // verifica se a placa já existe
    $check = $conexao->prepare("SELECT id FROM carros WHERE placa = :placa");
    $check->execute([':placa' => strtoupper($placa)]);
    if ($check->fetch()) {
        throw new RuntimeException('Placa já cadastrada.');
    }

    // insere o carro no banco
    $stmt = $conexao->prepare(
    "INSERT INTO carros (marca, modelo, ano, placa, url_foto, valor_diaria, status)
     VALUES (:marca, :modelo, :ano, :placa, :url_foto, :valor_diaria, :status)"
    );

    $stmt->execute([
    ':marca'         => trim($marca),
    ':modelo'        => trim($modelo),
    ':ano'           => $ano,
    ':placa'         => strtoupper(trim($placa)),
    ':url_foto'      => $url_foto,
    ':valor_diaria'  => $valor_diaria,
    ':status'        => $status,
    ]);

    return buscarCarro((int) $conexao->lastInsertId());
}

// =-=-=-=-=-=-=-=-==--=
// BUSCAR um carro
// =-=-=-=-=-=-=-=-==--=

function buscarCarro(int $id) {
    global $conexao;

    $sql = "SELECT id, marca, modelo, ano, placa, url_foto, valor_diaria, status, criado_em
            FROM carros 
            WHERE id = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([':id' => $id]);
    // retorna os dados ou false
    return $stmt->fetch();
}

// =-=-=-=-=-=-=-=-==--=
// DELETAR um carro 
// =-=-=-=-=-=-=-=-==--=

function deletarCarro(int $id): bool {
    global $conexao;

    // caso o carro não seja encontrado
    if (!buscarCarro($id)) {
        throw new RuntimeException('Carro não encontrado.');
    }

    $stmt = $conexao->prepare("DELETE FROM carros WHERE id = :id");
    $stmt->execute([':id' => $id]);

    return $stmt->rowCount() > 0;
}

// =-=-=-=-=-=-=-=-==--=
// ATUALIZAR um carro
// =-=-=-=-=-=-=-=-==--=

function atualizarCarro(int $id, string $marca, string $modelo, int $ano, string $placa, float $valor_diaria, string $status, ?string $url_foto = null): array {
    global $conexao;

    // verificar os dados
    validarDadosCarro($marca, $modelo, $ano, $placa, $valor_diaria, $status, $url_foto);

    // caso o carro não seja encontrado
    if (!buscarCarro($id)) {
        throw new RuntimeException('Carro não encontrado.');
    }

    // envia o query para o banco de dados
    $sql = "UPDATE carros 
        SET marca = :marca, modelo = :modelo, ano = :ano, placa = :placa, 
            url_foto = :url_foto, valor_diaria = :valor_diaria, status = :status
        WHERE id = :id";
    
    $stmt = $conexao->prepare($sql);
    // preenche as lacunas
    $stmt->execute([
    ':marca'         => trim($marca),
    ':modelo'        => trim($modelo),
    ':ano'           => $ano,
    ':placa'         => strtoupper(trim($placa)),
    ':url_foto'      => $url_foto,
    ':valor_diaria'  => $valor_diaria,
    ':status'        => $status,
    ':id'            => $id,
    ]);

    return buscarCarro($id);
}

// =-=-=-=-=-=-=-=-==--=
// VALIDAÇÃO de dados
// =-=-=-=-=-=-=-=-==--=

function validarDadosCarro( string $marca, string $modelo, int $ano, string $placa, float $valor_diaria, string $status, ?string $url_foto = null): void {

    // marca
    if (empty(trim($marca))) {
        throw new InvalidArgumentException('O campo marca é obrigatório.');
    }

    // modelo
    if (empty(trim($modelo))) {
        throw new InvalidArgumentException('O campo modelo é obrigatório.');
    }

    // ano
    if ($ano < 1900 || $ano > date('Y') + 1) {
        throw new InvalidArgumentException('Ano inválido. Use um ano entre 1900 e ' . (date('Y') + 1));
    }

    // placa
    if (empty(trim($placa)) || strlen(trim($placa)) !== 10) {
        throw new InvalidArgumentException('Placa inválida. Deve conter 10 caracteres.');
    }

    // valor_diaria
    if ($valor_diaria <= 0) {
        throw new InvalidArgumentException('O valor da diária deve ser maior que zero.');
    }

    // status
    if (!in_array($status, ['disponivel', 'alugado', 'manutencao'], true)) {
        throw new InvalidArgumentException('Status inválido. Use "disponivel", "alugado" ou "manutencao".');
    }

    // url_foto (opcional)
    if ($url_foto !== null && !filter_var($url_foto, FILTER_VALIDATE_URL) && !str_starts_with($url_foto, 'uploads/')) {
    throw new InvalidArgumentException('URL da foto inválida.');
    }
}