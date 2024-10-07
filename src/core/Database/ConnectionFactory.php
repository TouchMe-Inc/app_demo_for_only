<?php

namespace Core\Database;

class ConnectionFactory
{
    private const DRIVER_MYSQL = 'mysql';
    private const DRIVER_PGSQL = 'pgsql';
    private const DRIVER_SQLITE = 'sqlite';

    public function createConnection($driver, $pdo): Connection
    {
        switch ($driver) {
            case self::DRIVER_MYSQL:
                return new MySqlConnection($pdo);
            case self::DRIVER_PGSQL:
                return new PgSqlConnection($pdo);
            case self::DRIVER_SQLITE:
                return new SqliteConnection($pdo);
        }

        throw new \Exception("Driver '{$driver}' not supported");
    }
}