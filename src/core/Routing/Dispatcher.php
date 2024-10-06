<?php

namespace Core\Routing;

use Core\Http\Request;
use Exception;

class Dispatcher
{
    /**
     * @var Router
     */
    private Router $router;

    function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @throws Exception
     */
    public function dispatch(Request $request): void
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

        $response = call_user_func_array($route->getCallable(), $callbackParameters);

        var_dump($response);
    }
}