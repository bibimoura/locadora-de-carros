<?php
//reserva. php
require_once __DIR__ . '/../../config/database.php';


//=-=-=-=-=-=-=-=-=-=-=
// Listar reservas
//=-=-=-=-=-=-=-=-=-=-=

function ListarReservas(): array{
    global $conexao;

    $stmt = $conexao->query(
        "SELECT id, usuario_id, carro_id, data_inicio, data_fim, valor_total, criado_em
        FROM locacoes l
        INNER JOIN usuarios u ON l.usuario_id = u.id
        INNER JOIN carros c ON l.carro_id = c.id
        ORDER BY l.id ASC"
    );
    return $smtm->fetchAll();


}

