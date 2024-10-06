<?php

namespace Core\Database\Interface;

interface Connection
{
    /**
     * Disconnect from the underlying PDO connection.
     *
     * @return void
     */
    public function disconnect(): void;

    /**
     * @param string $query
     * @param array $bindings
     * @return array
     */
    public function select(string $query, array $bindings = []): array;

    /**
     * @param string $query
     * @param array $bindings
     * @return bool
     */
    public function insert(string $query, array $bindings = []): bool;

    /**
     * @param string $query
     * @param array $bindings
     * @return int
     */
    public function update(string $query, array $bindings = []): int;

    /**
     * @param string $query
     * @param array $bindings
     * @return int
     */
    public function delete(string $query, array $bindings = []): int;
}