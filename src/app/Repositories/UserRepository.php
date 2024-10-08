<?php

namespace App\Repositories;

use App\Models\User;
use Core\Database\Interface\Connection;

class UserRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param int $id
     * @return User
     */
    public function getById(int $id): User
    {
        $results = $this->connection->select("SELECT * FROM users WHERE id = :id", [":id" => $id]);

        $user = array_shift($results);

        return $this->mapToObject($user);
    }

    /**
     * @return User[]
     */
    public function all(): array
    {
        $results = $this->connection->select("SELECT * FROM users");

        $users = [];

        foreach ($results as $result) {
            $users[] = $this->mapToObject($result);
        }

        return $users;
    }

    private function mapToObject(array $result): User
    {
        $user = new User();

        $user->setId($result["id"]);
        $user->setName($result["name"]);
        $user->setEmail($result["email"]);
        $user->setPhone($result["phone"]);

        return $user;
    }
}