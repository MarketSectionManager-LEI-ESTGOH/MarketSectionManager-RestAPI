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

    public function getComponentesArea(String $numero)
    {
        $row = [
            'numero' => $numero
        ];

        $sql = "Select comp.id, comp.designacao, ap.area_id, lmp.`data` FROM componentes comp 
                INNER JOIN area_componentes ap 
                    ON comp.id = ap.componentes_id
	                AND ap.area_id = (Select id From area Where numero=:numero)
	            LEFT JOIN limpeza lmp
	                ON lmp.area_componentes_id = ap.id;";

        $db = $this->connection->prepare($sql);
        $db->execute($row);

        return $db->fetchAll();
    }
}
