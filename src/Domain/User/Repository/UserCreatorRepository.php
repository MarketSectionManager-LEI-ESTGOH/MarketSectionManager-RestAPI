<?php

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserCreatorRepository
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

    /**
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function insertUser(array $user): int
    {
        $row = [
            'tipo' => $user['tipo'],
            'nome' => $user['nome'],
            'num_interno' => $user['num_interno'],
            'password' => $user['password'],
            'email' => $user['email'],
        ];

        $sql = "INSERT INTO user SET 
                tipo=:tipo, 
                nome=:nome, 
                num_interno=:num_interno, 
                password=:password, 
                email=:email;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }
}

