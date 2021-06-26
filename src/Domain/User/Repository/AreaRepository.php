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

        $sql = "Select comp.id, comp.designacao, ap.area_id, MAX(lmp.`data`) as data FROM componentes comp
                INNER JOIN area_componentes ap 
                    ON comp.id = ap.componentes_id
	                AND ap.area_id = (Select id From area Where numero=:numero)
	            LEFT JOIN limpeza lmp
	                ON lmp.area_componentes_id = ap.id
                Group by id;";

        /*
        $sql = "Select comp.id, comp.designacao, ap.area_id FROM componentes comp 
                INNER JOIN area_componentes ap 
                    ON comp.id = ap.componentes_id
	                AND ap.area_id = (Select id From area Where numero=:numero);";
        */

        $db = $this->connection->prepare($sql);
        $db->execute($row);

        return $db->fetchAll();
    }

    public function putAreaCompenetesLimpos(array $data, int $user_id)
    {
        $final_res = array();
        //Get all area_componente id of componente/area combo
        $area_componentes_id = array();
        for($i = 0; $i < count($data); $i = $i+2){
            $row = [
                'area_id' => $data[$i],
                'componentes_id' => $data[$i+1]
            ];

            $sql = "Select id From area_componentes
                    Where area_id=:area_id AND componentes_id=:componentes_id;";
            $db = $this->connection->prepare($sql);
            $db->execute($row);
            $aux = $db->fetchAll();
            array_push($area_componentes_id, $aux[0]);

        }

        //print(count($area_componentes_id));
        //print_r($area_componentes_id);
        //Insert into limpeza
        for($i = 0; $i < count($area_componentes_id); $i++){
            $row = [
                'user_id' => $user_id,
                'area_componentes_id' => $area_componentes_id[$i]["id"]
            ];

            $sql = "INSERT INTO limpeza SET 
                        area_componentes_id=:area_componentes_id, 
                        user_id=:user_id;";
            $this->connection->prepare($sql)->execute($row);
            array_push($final_res, $this->connection->lastInsertId());
        }

        return $final_res;
    }

    public function getComponentesLimposByUser(int $id)
    {
        $row = [
            'id' => $id
        ];

        $sql = "Select * FROM(
                Select comp.designacao, ar.designacao as area_designacao, lmp.data as last_date
                From limpeza lmp
                INNER JOIN area_componentes ap 
                    ON ap.id = lmp.area_componentes_id
                INNER JOIN area ar 
                    ON ar.id = ap.area_id
                INNER JOIN componentes comp
                    ON comp.id = ap.componentes_id
                Where lmp.user_id=:id
                ORDER BY lmp.data DESC LIMIT 5)
                sub ORDER BY last_date ASC;";

        $db = $this->connection->prepare($sql);
        $db->execute($row);

        return $db->fetchAll();
    }
}
