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
        // TODO: Implement insert() method.
        return false;
    }

     public function select(string $query, array $bindings = []): array
     {
         // TODO: Implement select() method.
         return [];
     }

     public function update(string $query, array $bindings = []): int
     {
         // TODO: Implement update() method.
         return 0;
     }

     public function delete(string $query, array $bindings = []): int
     {
         // TODO: Implement delete() method.
         return 0;
     }
}