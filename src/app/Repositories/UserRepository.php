<?php

namespace App\Repositories;

use App\Collections\UserCollection;
use App\Mappers\UserMapper;
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
     * @return User|null
     */
    public function getById(int $id): ?User
    {
        $result = $this->connection->selectOne("SELECT * FROM users WHERE id = :id LIMIT 1", [":id" => $id]);

        if (!is_null($result)) {
            return UserMapper::toObject($result);
        }

        return null;
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return UserCollection
     */
    public function getPage(int $page, int $perPage): UserCollection
    {
        $results = $this->connection->select(
            "SELECT * FROM users LIMIT :limit OFFSET :offset",
            [":limit" => $perPage, ":offset" => $perPage * ($page - 1)]
        );

        $users = new UserCollection();

        foreach ($results as $result) {
            $users->push(UserMapper::toObject($result));
        }

        return $users;
    }

    public function create(array $data): bool
    {
        return $this->connection->insert("INSERT INTO users (name, email, phone, password) VALUES (:name, :email, :phone, :password)", $data);
    }

    public function update(int $id, array $data): int
    {
        return $this->connection->update("UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id", [":id" => $id, ...$data]);
    }

    public function delete(int $id): int
    {
        return $this->connection->delete("DELETE FROM users WHERE id = :id", [":id" => $id]);
    }

    public function existsById(int $id): bool
    {
        $result = $this->connection->selectOne("SELECT COUNT(id) FROM users");

        return (int)$result > 0;
    }
}