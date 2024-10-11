<?php /** @noinspection ALL */

namespace Core\Routing;

use Core\Request\Request;
use Core\Response\Response;
use Core\Container\Container;
use Core\Routing\Exception\RouteNotFoundException;

class Router
{
    private RouteCollection $collection;

    public function __construct()
    {
        $this->collection = new RouteCollection();
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function get(string $uri, mixed $handler): self
    {
        $this->collection->add(Request::METHOD_GET, $uri, $handler);
        return $this;
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function post(string $uri, mixed $handler): self
    {
        $this->collection->add(Request::METHOD_POST, $uri, $handler);
        return $this;
    }


    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function put(string $uri, mixed $handler): self
    {
        $this->collection->add(Request::METHOD_PUT, $uri, $handler);
        return $this;
    }


    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function patch(string $uri, mixed $handler): self
    {
        $this->collection->add(Request::METHOD_PATCH, $uri, $handler);
        return $this;
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function delete(string $uri, mixed $handler): self
    {
        $this->collection->add(Request::METHOD_DELETE, $uri, $handler);
        return $this;
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function head(string $uri, mixed $handler): self
    {
        $this->collection->addRoute(Request::METHOD_HEAD, $uri, $handler);
        return $this;
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function options(string $uri, mixed $handler): self
    {
        $this->collection->add(Request::METHOD_OPTIONS, $uri, $handler);
        return $this;
    }

    /**
     * @param Request $request
     * @return Route
     * @throws RouteNotFoundException
     */
    public function matchByRequest(Request $request): Route
    {
        return $this->collection->match($request->getMethod(), $request->getUri());
    }

    /**
     * @param Request $request
     * @return void
     * @throws RouteNotFoundException
     * @throws Exception
     */
    public function dispatchRequest(Request $request): Response
    {
        $route = $this->matchByRequest($request);

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
            return $callbackResult;
        } elseif (gettype($callbackResult) === 'string') {
            return (new Response($callbackResult, 200));
        }

        throw new Exception("Unexpected error occurred");
    }

    /**
     * @param mixed $handler
     * @return callable
     * @throws Exception
     */
    private function resolveHandler(\Closure|array $handler): callable
    {
        if (is_array($handler) && is_string($handler[0])) {
            $handler[0] = (new Container())->make($handler[0]);
        }

        if (is_callable($handler)) {
            return $handler;
        }

        throw new Exception("Handler '$handler' not resolved.");
    }
}
