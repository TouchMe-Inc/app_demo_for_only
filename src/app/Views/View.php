<?php

namespace App\Views;

use Core\Render\Interface\Renderer;
use Core\Render\NativeRender;

class View
{

    private static Renderer|null $renderer = null;

    public static function render(string $view, array $data = []): string
    {
        return self::getRenderer()->render(
            basepath() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . ".php",
            $data
        );
    }

    public static function layout(string $view, array $data = []): string
    {
        return self::render('layouts' . DIRECTORY_SEPARATOR . $view, $data);
    }

    public static function page(string $view, array $data = []): string
    {
        return self::render('pages' . DIRECTORY_SEPARATOR . $view, $data);
    }

    public static function component(string $view, array $data = []): string
    {
        return self::render('components' . DIRECTORY_SEPARATOR . $view, $data);
    }

    private static function getRenderer(): Renderer
    {
        if (is_null(self::$renderer)) {
            self::$renderer = new NativeRender();
        }

        return self::$renderer;
    }
}