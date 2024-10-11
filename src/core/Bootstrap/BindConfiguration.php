<?php

namespace Core\Bootstrap;

use Core\Application;
use Core\Bootstrap\Interface\Bootstrapper;
use Core\Configuration\Configuration;

class BindConfiguration implements Bootstrapper
{

    public function bootstrap(Application $app): void
    {
        $app->container()->addInstance(Configuration::class, $app->configuration());
    }
}