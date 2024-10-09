<?php

use Core\Application;

if (!function_exists('app')) {
    function app()
    {
        return Application::getInstance();
    }
}