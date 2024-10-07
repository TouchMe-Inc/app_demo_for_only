<?php

namespace Core\Bootstrap;

use Core\Application;
use Core\Bootstrap\Interface\Bootstrapper;
use Core\Config\Configuration;

class LoadConfiguration implements Bootstrapper
{

    public function bootstrap(Application $app): void
    {
        $configuration = $app->getContainer()->make(Configuration::class);

        foreach (glob($app->getConfigPath("*.php")) as $filePath) {
            $configuration->set(basename($filePath, ".php"), require $filePath);
        }
    }
}