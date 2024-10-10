<?php

namespace Core\Database;

use Core\Database\Exception\DriverNotSupportedException;
use Core\Database\Interface\Connector;


class ConnectionFactory
{
    public const DRIVER_MYSQL = 'mysql';
    public const DRIVER_PGSQL = 'pgsql';
    public const DRIVER_SQLITE = 'sqlite';

    /**
     * @param $driver
     * @param array $options
     * @return Connection
     * @throws DriverNotSupportedException
     */
    public function createConnection($driver, array $options): Connection
    {
        if (!$this->isSupportedDriver($driver)) {
            throw new DriverNotSupportedException();
        }

        /** @var Connector $connector */
        $connector = match ($driver) {
            self::DRIVER_MYSQL => new MySqlConnector(),
            self::DRIVER_PGSQL => new PgSqlConnector(),
            self::DRIVER_SQLITE => new SqliteConnector()
        };

        $pdo = $connector->connect($options);

        return match ($driver) {
            self::DRIVER_MYSQL => new MySqlConnection($pdo),
            self::DRIVER_PGSQL => new PgSqlConnection($pdo),
            self::DRIVER_SQLITE => new SqliteConnection($pdo)
        };
    }

    private function isSupportedDriver(string $driver): bool
    {
        return in_array($driver, [self::DRIVER_MYSQL, self::DRIVER_PGSQL, self::DRIVER_SQLITE]);
    }
}