<?php

namespace App\Bootstrap;

use Core\Application;
use Core\Bootstrap\Interface\Bootstrapper;
use Core\Configuration\Configuration;

class LoadConfiguration implements Bootstrapper
{

    public function bootstrap(Application $app): void
    {
        $configPath = $app->getBasePath('config' . DIRECTORY_SEPARATOR . '*.php');

        foreach (glob($configPath) as $filePath) {
            $app->configuration()->set(basename($filePath, ".php"), require $filePath);
        }
    }
}