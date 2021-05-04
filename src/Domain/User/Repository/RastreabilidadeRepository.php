<?php

namespace App\Domain\User\Repository;

use PDO;
use function PHPUnit\Framework\isEmpty;

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
        $fornecedorIdentificacao = $this->getFornecedorbyIdentificador($rast['fornecedor_id']);
        $produtoNumeroInterno = $this->getProdutobyNumInterno($rast['produto_id']);
        if(empty($fornecedorIdentificacao)) return -2;
        if(empty($produtoNumeroInterno)) return -3;


        $row = [
            'lote' => $rast['lote'],
            'produto_id' => $produtoNumeroInterno[0]['id'],
            'user_id' => $rast['user_id'],
            'fornecedor_id' => $fornecedorIdentificacao[0]['id'],
            'origem' => $rast['origem']
        ];

        $sql = "INSERT INTO rastreabilidade SET 
            lote=:lote, 
            produto_id=:produto_id, 
            user_id=:user_id, 
            origem=:origem,
            fornecedor_id=:fornecedor_id;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    public function getFornecedorbyIdentificador($identificaddor){
        $sql = "SELECT id FROM fornecedor WHERE identificador=:identificador;";

        $row=['identificador' => $identificaddor];

        $db = $this->connection->prepare($sql);
        $db->execute($row);

        return $db->fetchAll();
    }

    public function getProdutobyNumInterno($numInterno){
        $sql = "SELECT id FROM produto WHERE n_interno=:n_interno;";

        $row=['n_interno' => $numInterno];

        $db = $this->connection->prepare($sql);
        $db->execute($row);

        return $db->fetchAll();
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