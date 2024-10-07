<?php

namespace App\Http\Controllers;

use Core\Application;
use Core\Render\NativeRender;

class HomeController
{

    public function index(): string
    {
        // TODO: Simplify this

        return (new NativeRender())->render(
            Application::getInstance()->getBasePath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . "Views/home.php",
            ["customString" => "Is my custom string"]
        );
    }
}