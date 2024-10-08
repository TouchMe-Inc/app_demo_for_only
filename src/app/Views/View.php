<?php

namespace App\Views;

use Core\Render\NativeRender;

class View
{
    public static function foo(): string
    {
        return 'foo';
    }

    public static function render(string $view, array $data = []): string
    {
        return (new NativeRender())->render(
            __DIR__ . DIRECTORY_SEPARATOR . $view . ".php",
            $data
        );
    }
}