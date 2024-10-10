<?php

namespace Core\Database;

use Core\Database\Interface\Connector;
use PDO;

class PgSqlConnector implements Connector
{

    public function connect(array $params): PDO
    {
        $dsn = $params['dsn'] ?? "pgsql:host={$params['host']};port={$params['port']};dbname={$params['database']}";
        $user = $params['user'];
        $password = $params['password'];
        $options = $params['options'] ?? null;

        return new PDO($dsn, $user, $password, $options);
    }
}