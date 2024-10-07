<?php

namespace App\Http\Controllers;

use Core\Application;
use Core\Render\NativeRender;

class HomeController
{

    public function index(): string
    {
        // TODO: Simplify this

        $render = new NativeRender();

        $page = $render->render(
            Application::getInstance()->getBasePath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . "Views/pages/home.php",
            ["customString" => "Is my custom string"]
        );

        return $render->render(
            Application::getInstance()->getBasePath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . "Views/layouts/base.php",
            ["slot" => $page]
        );
    }
}