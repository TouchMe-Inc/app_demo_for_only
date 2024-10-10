<?php

namespace Core\Database;

use Core\Database\Interface\Connector;
use PDO;

class MysqlConnector implements Connector
{

    public function connect(array $params): PDO
    {
        $dsn = $params['dsn'] ?? "mysql:host={$params['host']};port={$params['port']};dbname={$params['database']}";
        $user = $params['user'];
        $password = $params['pass'];
        $options = $params['options'];

        return new PDO($dsn, $user, $password, $options);
    }
}