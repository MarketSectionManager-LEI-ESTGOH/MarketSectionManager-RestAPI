<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class LoginCreatorRepository
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

    public function searchUser(array $user): ?array
    {
        /*
        $row = [
            'num_interno' => $user['num_interno'],
            'password' => password_hash($user['password'], PASSWORD_BCRYPT),
        ];
        */

        $row = [
            'num_interno' => $user['num_interno'],
        ];

        $sql = "SELECT * FROM user WHERE 
                num_interno=:num_interno;";

        $stmt = $this->connection->prepare($sql);
        if(!$stmt->execute($row)){
            return null;
        }
        return $stmt->fetchAll();
    }
}

