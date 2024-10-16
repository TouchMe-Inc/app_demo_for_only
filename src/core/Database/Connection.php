<?php

namespace Core\Database;

use \Core\Database\Interface\Connection as ConnectionInterface;
use PDO;
use PDOStatement;

abstract class Connection implements ConnectionInterface
{
    protected PDO|null $pdo;

    /**
     * Create a new database connection instance.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function disconnect(): void
    {
        $this->pdo = null;
    }

    public function insert(string $query, array $bindings = []): bool
    {
        $statement = $this->prepareStatement($query, $bindings);

        return $statement->execute();
    }

    public function select(string $query, array $bindings = []): array
    {
        $statement = $this->prepareStatement($query, $bindings);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectOne(string $query, array $bindings = [])
    {
        $results = $this->select($query, $bindings);

        return array_shift($results);
    }

    public function update(string $query, array $bindings = []): int
    {
        $statement = $this->prepareStatement($query, $bindings);

        $statement->execute();

        return $statement->rowCount();
    }

    public function delete(string $query, array $bindings = []): int
    {
        $statement = $this->prepareStatement($query, $bindings);

        $statement->execute();

        return $statement->rowCount();
    }

    private function prepareStatement(string $query, array $bindings = []): PDOStatement
    {
        $statement = $this->pdo->prepare($query);

        foreach ($bindings as $key => $value) {
            $statement->bindValue($key, $value, match (true) {
                is_int($value) => PDO::PARAM_INT,
                default => PDO::PARAM_STR,
            });
        }

        return $statement;
    }
}