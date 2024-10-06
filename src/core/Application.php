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

    public function handleRequest(Request $request): void
    {
        try {
            $router = new Router();
            $router->get("/view/{id:\d+}/{data:\d+}", [HomeController::class, "view"]);
            $router->get("/", [HomeController::class, "index"]);

            $dispatcher = new Dispatcher($router);

            $dispatcher->dispatch($request);
        } catch (Exception $exception) {
            // TODO: add error handler
        }
    }
}