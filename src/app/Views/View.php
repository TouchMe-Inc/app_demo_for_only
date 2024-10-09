<?php

namespace App\Views;

use Core\Render\NativeRender;

class View
{

    public static function render(string $view, array $data = []): string
    {
        return (new NativeRender())->render(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . ".php",
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
}