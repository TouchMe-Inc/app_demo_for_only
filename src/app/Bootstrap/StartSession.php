<?php

namespace App\Bootstrap;

use Core\Application;
use Core\Bootstrap\Interface\Bootstrapper;
use Core\Session\interface\Session as SessionInterface;
use Core\Session\Session;

class StartSession implements Bootstrapper
{

    public function bootstrap(Application $app): void
    {
        $session = $app->container()->make(Session::class); // TODO: SessionBuilder?

        $session->start();

        $app->container()->bind(SessionInterface::class, $session);
    }
}