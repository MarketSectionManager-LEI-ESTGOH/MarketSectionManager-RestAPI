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
}
