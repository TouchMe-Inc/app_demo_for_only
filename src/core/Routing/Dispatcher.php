<?php

namespace Core\Routing;

use Core\Container\Container;
use Core\Request\Request;
use Core\Response\Response;
use Core\Routing\Exception\RouteNotFoundException;
use Exception;

class Dispatcher
{
    /**
     * @var Router
     */
    private Router $router;

    private Container $container;

    function __construct(Router $router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
    }


    /**
     * @param Request $request
     * @return void
     * @throws RouteNotFoundException
     * @throws Exception
     */
    public function dispatch(Request $request): void
    {
        $route = $this->router->matchByRequest($request);

        $callbackParameters = [];

        if ($route->getVariableNames() && preg_match($route->getRegex(), $request->getUri(), $matches) && $matches) {
            $variableValues = array_slice($matches, 1);

            // TODO: check this case
            if (count($variableValues) !== count($route->getVariableNames())) {
                throw new Exception("Route variables do not match.");
            }

            $callbackParameters = array_combine($route->getVariableNames(), $variableValues);
        }

        $resolvedHandler = $this->resolveHandler($route->getHandler());

        $callbackResult = call_user_func_array($resolvedHandler, $callbackParameters);

        if ($callbackResult instanceof Response) {
            $callbackResult->send();
        } elseif (gettype($callbackResult) === 'string') {
            (new Response($callbackResult, 200))->send();
        } else {
            throw new Exception("Unexpected error occurred");
        }
    }

    /**
     * @param mixed $handler
     * @return callable
     * @throws Exception
     */
    private function resolveHandler(\Closure|array $handler): callable
    {
        if (is_array($handler) && is_string($handler[0])) {
            $handler[0] = $this->container->make($handler[0]);
        }

        if (is_callable($handler)) {
            return $handler;
        }

        throw new Exception("Handler '$handler' not resolved.");
    }
}