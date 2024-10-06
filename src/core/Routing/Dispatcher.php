<?php

namespace Core\Routing;

use Core\Container\Container;
use Core\Http\Request;
use Exception;

class Dispatcher
{
    /**
     * @var Router
     */
    private Router $router;

    private Container $container;

    function __construct(Router $router)
    {
        $this->router = $router;
        $this->container = Container::getInstance();
    }

    /**
     * @throws Exception
     */
    public function dispatch(Request $request)
    {
        $route = $this->router->match($request);

        $callbackParameters = [];

        if ($route->getVariableNames() && preg_match($route->getRegex(), $request->getUri(), $matches) && $matches) {
            $variableValues = array_slice($matches, 1);

            if (count($variableValues) !== count($route->getVariableNames())) {
                throw new Exception("Route variables do not match");
            }

            $callbackParameters = array_combine($route->getVariableNames(), $variableValues);
        }

        $resolvedHandler = $this->resolveHandler($route->getHandler());

        $response = call_user_func_array($resolvedHandler, $callbackParameters);

        return $response;
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