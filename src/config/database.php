<?php

return [
    'driver' => 'mysql',
    'connection' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => 'mysql-8.2',
            'port' => '3306',
            'user' => 'root',
            'password' => '',
            'database' => 'test',
            'charset' => 'utf8',
        ],
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => 'localhost',
            'port' => '3306',
            'user' => 'root',
            'password' => '',
            'database' => 'test',
            'charset' => 'utf8',
        ],
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => 'test',
            'charset' => 'utf8',
        ]
    ]
];
