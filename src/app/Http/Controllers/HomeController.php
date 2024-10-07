<?php

namespace App\Http\Controllers;

use Core\Application;
use Core\Container\Container;
use Core\Render\NativeRender;

class HomeController
{

    public function index(): string
    {
        // TODO: Simplify this

        /** @var Application $app */
        $app = Container::getInstance()->make(Application::class);

        return (new NativeRender())->render($app->getBasePath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . "Views/home.php", ["customString" => "Is my custom string"]);
    }
}