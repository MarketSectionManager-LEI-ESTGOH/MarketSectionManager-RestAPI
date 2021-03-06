<?php

namespace App\Domain\User\Repository;

use PDO;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Repository.
 */
class AreaFrigorificaRepository
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


    public function insertAreaFrigorifica(array $areaF): int
    {
        $row = [
            'numero' => $areaF['numero'],
            'designacao' => $areaF['designacao'],
            'fabricante' => $areaF['fabricante'],
            'd_t_adicao' => date('Y-m-d H:i:s'),
            'tem_min' => $areaF['tem_min'],
            'tem_max' => $areaF['tem_max'],
        ];

        $sql = "INSERT INTO area_frigorifica SET 
                numero=:numero, 
                designacao=:designacao, 
                fabricante=:fabricante, 
                d_t_adicao=:d_t_adicao,
                tem_min=:tem_min,
                tem_max=:tem_max;";

        try{
            $this->connection->prepare($sql)->execute($row);
        }catch (\Exception $e){
            return -1;
            //print($e);
        }


        return (int)$this->connection->lastInsertId();
    }

    public function insertAreaFrigorificaLimpeza(array $areaF) : int
    {
        $row = [
            'd_t_limpeza' => date('Y-m-d H:i:s'),
            'user_limpeza' => $areaF['user_limpeza'],
            'id' => $areaF['id']
    ];

    $sql = "UPDATE area_frigorifica SET 
                d_t_limpeza=:d_t_limpeza, 
                user_limpeza=:user_limpeza
                WHERE numero=:id;";

    $db = $this->connection->prepare($sql);
    $db->execute($row);

    return (int)$db->rowCount();
}

    public function getAreaFrigorifica()
    {
        $sql = "SELECT * FROM area_frigorifica;";

        $db = $this->connection->prepare($sql);
        $db->execute();

        return $db->fetchAll();
    }

    public function insertAreaFrigorificaTemperatura(array $areaF) : int
    {
        $row = [
            'data_hora' => date('Y-m-d H:i:s'),
            'temperatura' => $areaF['temperatura'],
            'user_id' => $areaF['user_id'],
            'area_frigorifica_id' => $areaF['area_frigorifica_id']
        ];

        $sql = "INSERT INTO temperatura SET 
                temperatura=:temperatura, 
                data_hora=:data_hora, 
                user_id=:user_id, 
                area_frigorifica_id=:area_frigorifica_id;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    public function getAreaFrigorificaTemperaturaByUser(int $id)
    {
        $row = [
            'user_id' => $id,
        ];

        $sql = "Select * FROM 
                (Select temp.temperatura, temp.data_hora, temp.area_frigorifica_id, af.designacao
                    FROM temperatura temp, area_frigorifica af
                    WHERE user_id=:user_id
                    AND temp.area_frigorifica_id = af.numero
                    ORDER BY data_hora DESC LIMIT 10) 
                sub ORDER BY data_hora ASC;";

        $db = $this->connection->prepare($sql);
        $db->execute($row);

        return $db->fetchAll();
    }
}

