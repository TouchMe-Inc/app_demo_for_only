<?php

use Core\Application;
use Core\Container\Container;

if (!function_exists('app')) {
    function app(): Application
    {
        return Application::getInstance();
    }
}

if (!function_exists('container')) {
    function container(): Container
    {
        return app()->container();
    }
}

if (!function_exists('basepath')) {
    function basepath(): string
    {
        return app()->getBasePath();
    }
}