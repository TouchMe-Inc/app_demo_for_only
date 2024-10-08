<?php

namespace Core\Bootstrap;

use Core\Application;
use Core\Bootstrap\Interface\Bootstrapper;
use Core\Container\Container;

class BindContainer implements Bootstrapper
{

    public function bootstrap(Application $app): void
    {
        $app->container()->addInstance(Container::class, $app->container());
    }
}