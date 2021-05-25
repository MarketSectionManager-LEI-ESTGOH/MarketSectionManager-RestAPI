<?php

namespace App\Domain\User\Repository;

use PDO;
use function PHPUnit\Framework\isEmpty;

/**
 * Repository.
 */
class AreaRepository
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

    public function getAreas()
    {

        $sql = "Select * FROM area;";

        $db = $this->connection->prepare($sql);
        $db->execute();

        return $db->fetchAll();
    }
}
