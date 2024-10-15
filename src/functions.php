<?php

use Core\Application;
use Core\Container\Container;
use Core\Request\Request;
use Core\Routing\Router;

if (!function_exists('app')) {
    /**
     * @return Application
     */
    function app(): Application
    {
        return Application::getInstance();
    }
}

if (!function_exists('container')) {
    /**
     * @return Container
     * @throws Exception
     */
    function container(): Container
    {
        return app()->container();
    }
}

if (!function_exists('router')) {
    /**
     * @return Router
     */
    function router(): Router
    {
        return app()->router();
    }
}

if (!function_exists('basepath')) {
    /**
     * @return string
     */
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