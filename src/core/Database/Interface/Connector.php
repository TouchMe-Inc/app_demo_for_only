<?php

namespace Core\Database\Interface;

use PDO;

interface Connector
{
    /**
     * @param array $params
     * @return PDO
     */
    public function connect(array $params): PDO;
}