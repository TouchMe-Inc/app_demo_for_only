<?php

namespace Core;

use App\Http\Controllers\HomeController;
use Core\Container\Container;
use Core\Http\Request;
use Core\Routing\Dispatcher;
use Core\Routing\Router;
use Exception;

class Application
{
    private Container $container;

    public function __construct()
    {
        $this->container = Container::getInstance();
    }

    public function handleRequest(Request $request): void
    {
        try {
            $router = $this->container->make(Router::class);
            $router->get("/view/{id:\d+}/{data:\d+}", [HomeController::class, "view"]);
            $router->get("/", [HomeController::class, "index"]);

            $dispatcher = $this->container->make(Dispatcher::class);

            print_r($dispatcher->dispatch($request));
        } catch (Exception $exception) {
            // TODO: add error handler
            print_r($exception->getMessage());
        }
    }
}