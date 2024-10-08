<?php

namespace App\Http\Controllers;

use Core\Application;
use Core\Render\NativeRender;

class UserController
{
    public function index(): string
    {
        // TODO: Simplify this

        $render = new NativeRender();

        $page = $render->render(
            Application::getInstance()->getBasePath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . "Views/pages/users.php"
        );

        return $render->render(
            Application::getInstance()->getBasePath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . "Views/layouts/base.php",
            ["slot" => $page]
        );
    }
}