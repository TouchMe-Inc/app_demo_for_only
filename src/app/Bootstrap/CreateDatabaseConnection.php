<?php

namespace App\Bootstrap;

use Core\Application;
use Core\Bootstrap\Interface\Bootstrapper;
use Core\Configuration\Configuration;
use Core\Database\ConnectionFactory;
use Core\Database\Interface\Connection;

class CreateDatabaseConnection implements Bootstrapper
{

    public function bootstrap(Application $app): void
    {
        $configuration = $app->container()->make(Configuration::class)->get("database");

        $driver = $configuration["driver"];
        $options = $configuration['connection'][$driver];

        $connection = $app->container()
            ->make(ConnectionFactory::class)
            ->createConnection($driver, $options);

        $app->container()->bind(
            Connection::class,
            $connection
        );
    }
}