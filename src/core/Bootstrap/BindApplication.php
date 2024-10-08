<?php

namespace Core\Bootstrap;

use Core\Application;
use Core\Bootstrap\Interface\Bootstrapper;

class BindApplication implements Bootstrapper
{

    public function bootstrap(Application $app): void
    {
        $app->container()->addInstance(Application::class, $app);
    }
}