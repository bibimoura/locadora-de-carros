<?php

require_once __DIR__ . '/../../config/database.php';


// =-=-=-=-=-=-=-=-==--=
// LISTAR clientes
// =-=-=-=-=-=-=-=-==--=

function listarClientes(): array {
    global $conexao;
    // percorre todos os resultados e retorna tudo de uma vez
    $stmt = $conexao->query(
        "SELECT id, nome, email, tipo, criado_em
         FROM usuarios
         ORDER BY id ASC"
    );
    return $stmt->fetchAll();

}

// =-=-=-=-=-=-=-=-==--=
// CRIAR um novo cliente 
// =-=-=-=-=-=-=-=-==--=

function criarCliente(string $nome, string $email, string $senha, string $tipo = 'cliente'): array{
    global $conexao;

    // verificar os dados do novo cliente
    validarDados($nome,$email,$senha,$tipo);

    // verifica se o email já existe
    $check = $conexao->prepare("SELECT id FROM usuarios WHERE email = :email");
    $check->execute([':email' => $email]);
    if ($check->fetch()) {
    throw new RuntimeException('E-mail já cadastrado.');
    }

    // insere o cliente no banco
    $stmt = $conexao->prepare(
        "INSERT INTO usuarios (nome, email, senha, tipo)
         VALUES (:nome, :email, :senha, :tipo)"
    );
    $stmt->execute([
        ':nome'  => trim($nome),
        ':email' => trim($email),
        ':senha' => password_hash($senha, PASSWORD_BCRYPT),
        ':tipo'  => $tipo,
    ]);

    return buscarCliente((int) $conexao->lastInsertId());
}

// =-=-=-=-=-=-=-=-==--=
// BUSCAR um cliente
// =-=-=-=-=-=-=-=-==--=

function buscarCliente(int $id){
    global $conexao;

    // busca apenas os tipo = 'cliente'
    $sql = "SELECT id, nome, email 
            FROM usuarios 
            WHERE id = :id AND tipo = 'cliente'";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([':id' => $id]);
    // retorna os dados ou false
    return $stmt->fetch();
}

// =-=-=-=-=-=-=-=-==--=
// DELETAR um cliente 
// =-=-=-=-=-=-=-=-==--=

function deletarCliente(int $id): bool {
    global $conexao;

    // caso o cliente não seja encontrado
    if (!buscarCliente($id)) {
        throw new RuntimeException('Cliente não encontrado.');
    }

    $stmt = $conexao->prepare( "DELETE FROM usuarios WHERE id = :id AND tipo = 'cliente'");
    $stmt->execute([':id' => $id]);

    return $stmt->rowCount() > 0;
}

// =-=-=-=-=-=-=-=-==--=
// ATUALIZAR um cliente
// =-=-=-=-=-=-=-=-==--=

function atualizarCliente(int $id, string $nome, string $email, string $senha, string $tipo): array {
    global $conexao;

    // verificar os dados
    validarDados($nome, $email, $senha, $tipo);

    // caso o cliente não seja encontrado
    if (!buscarCliente($id)) {
        throw new RuntimeException('Cliente não encontrado.');
    }

    // envia o query para o banco de dados
    $sql = "UPDATE usuarios 
            SET nome = :nome, email = :email, senha = :senha
            WHERE id = :id AND tipo = 'cliente'";
    
    $stmt = $conexao->prepare($sql);
    // preenche as lacunas
    $stmt->execute([
        ':nome'  => $nome,
        ':email' => $email,
        ':senha' => password_hash($senha, PASSWORD_BCRYPT),
        ':id'    => $id,
    ]);

    return buscarCliente($id);
}

// =-=-=-=-=-=-=-=-==--=
// VALIDAÇÃO de dados
// =-=-=-=-=-=-=-=-==--=
function validarDados(string $nome, string $email, string $senha, string $tipo): void {

    //nome
    if (empty(trim($nome))) {
        throw new InvalidArgumentException('O campo nome é obrigatório.');
    }
    //email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException('E-mail inválido.');
    }
    //senha
    if (strlen($senha) < 6) {
        throw new InvalidArgumentException('A senha deve ter no mínimo 6 caracteres.');
    }
    //cliente
    if (!in_array($tipo, ['cliente', 'admin'], true)) {
        throw new InvalidArgumentException('Tipo inválido. Use "cliente" ou "admin".');
    }
}