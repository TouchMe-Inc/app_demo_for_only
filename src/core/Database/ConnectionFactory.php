<?php

namespace Core\Database;

use Exception;

class ConnectionFactory
{
    public const DRIVER_MYSQL = 'mysql';
    public const DRIVER_PGSQL = 'pgsql';
    public const DRIVER_SQLITE = 'sqlite';

    /**
     * @throws Exception
     */
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

        throw new Exception("Driver '{$driver}' not supported");
    }
}