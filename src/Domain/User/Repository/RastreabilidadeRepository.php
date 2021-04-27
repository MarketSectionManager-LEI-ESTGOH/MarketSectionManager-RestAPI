<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class RastreabilidadeRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function addRastreabilidade(array $rast): int
    {
        $row = [
            'lote' => $rast['lote'],
            'produto_id' => $rast['produto_id'],
            'user_id' => $rast['user_id'],
            'fornecedor_id' => $rast['fornecedor_id']
        ];

        $sql = "INSERT INTO rastreabilidade SET 
                lote=:lote, 
                produto_id=:produto_id, 
                user_id=:user_id, 
                fornecedor_id=:fornecedor_id;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    public function getFornecedores()
    {
        $sql = "SELECT * FROM fornecedor;";

        $db = $this->connection->prepare($sql);
        $db->execute();

        return $db->fetchAll();
    }

    public function getProdutos()
    {
        $sql = "SELECT * FROM produto;";

        $db = $this->connection->prepare($sql);
        $db->execute();

        return $db->fetchAll();
    }
}