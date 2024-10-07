<?php

namespace Core\Bootstrap\Interface;

use Core\Application;

interface Bootstrapper
{
    public function bootstrap(Application $app): void;
}