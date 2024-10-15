<?php

use Core\Application;
use Core\Container\Container;
use Core\Request\Request;
use Core\Routing\Router;

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

if (!function_exists('router')) {
    function router(): Router
    {
        return app()->router();
    }
}

if (!function_exists('basepath')) {
    function basepath(): string
    {
        return app()->getBasePath();
    }
}

if (!function_exists('request')) {
    /**
     * @return Request
     */
    function request(): Request
    {
        return app()->container()->make(Request::class);
    }
}