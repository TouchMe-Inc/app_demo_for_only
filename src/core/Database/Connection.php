<?php

namespace Core\Database;

use PDO;

abstract class Connection implements Interface\Connection
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
        $statement = $this->pdo->prepare($query);

        foreach ($bindings as $binding) {
            $statement->bindValue($binding, $binding, match (true) {
                is_int($binding) => PDO::PARAM_INT,
                default => PDO::PARAM_STR,
            });
        }

        return $statement->execute();
    }

    public function select(string $query, array $bindings = []): array
    {
        $statement = $this->pdo->prepare($query);

        foreach ($bindings as $binding) {
            $statement->bindValue($binding, $binding, match (true) {
                is_int($binding) => PDO::PARAM_INT,
                default => PDO::PARAM_STR,
            });
        }

        $statement->execute();

        return $statement->fetchAll();
    }

    public function update(string $query, array $bindings = []): int
    {
        $statement = $this->pdo->prepare($query);

        foreach ($bindings as $binding) {
            $statement->bindValue($binding, $binding, match (true) {
                is_int($binding) => PDO::PARAM_INT,
                default => PDO::PARAM_STR,
            });
        }

        $statement->execute();

        return $statement->rowCount();
    }

    public function delete(string $query, array $bindings = []): int
    {
        $statement = $this->pdo->prepare($query);

        foreach ($bindings as $binding) {
            $statement->bindValue($binding, $binding, match (true) {
                is_int($binding) => PDO::PARAM_INT,
                default => PDO::PARAM_STR,
            });
        }

        $statement->execute();

        return $statement->rowCount();
    }
}