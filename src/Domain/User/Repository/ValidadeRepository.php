<?php


namespace App\Domain\User\Repository;

use PDO;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Repository.
 */
class ValidadeRepository
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

    public function getProdutoByEAN(string $ean)
    {
        $row = [
            'ean' => $ean,
        ];

        $sql = "Select id, n_interno, nome, marca FROM produto where ean=:ean;";

        $db = $this->connection->prepare($sql);
        $db->execute($row);

        return $db->fetchAll();
    }

    public function insertValidadeProduto(array $data)
    {
        $results = $this->getProdutoByEAN($data['ean']);
        //print_r($results);
        if(sizeof($results) == 0){
            return -1;
        }else{
            $row = [
                'ean' => $data['ean'],
                'validade' => $data['validade'],
                'n_interno' => $results[0]['n_interno'],
                'nome' => $results[0]['nome'],
                'produto_id' => $results[0]['id']
            ];
        }

        $sql = "INSERT INTO validade SET 
            ean=:ean, 
            validade=:validade, 
            n_interno=:n_interno, 
            nome=:nome,
            produto_id=:produto_id;";

        try{
            $this->connection->prepare($sql)->execute($row);
        }catch (\Exception $e){
            return -1;
        }

        return (int)$this->connection->lastInsertId();
    }
}
