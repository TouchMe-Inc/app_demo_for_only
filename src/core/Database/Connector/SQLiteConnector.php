<?php

namespace Core\Database\Connector;

use Core\Database\Interface\Connector;
use PDO;

class SQLiteConnector implements Connector
{

    public function connect(array $params): PDO
    {
        $dsn = 'sqlite:' . $params['path'];
        $options = $params['options'] ?? null;

        return new PDO($dsn, null, null, $options);
    }
}