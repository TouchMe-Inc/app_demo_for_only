<?php /** @noinspection ALL */

namespace Core\Routing;

use Core\Request\Request;
use Core\Response\Response;
use Core\Container\Container;
use Core\Routing\Exception\RouteNotFoundException;

class Router
{
    private RouteCollection $collection;
    private Container $container;

    private string $currentGroupPrefix = "";

    public function __construct(Container $container)
    {
        $this->collection = new RouteCollection();
        $this->container = $container;
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function get(string $uri, mixed $handler): self
    {
        return $this->add([Request::METHOD_GET], $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function post(string $uri, mixed $handler): self
    {
        return $this->add([Request::METHOD_POST], $uri, $handler);
    }


    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function put(string $uri, mixed $handler): self
    {
        return $this->add([Request::METHOD_PUT], $uri, $handler);
    }


    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function patch(string $uri, mixed $handler): self
    {
        return $this->add([Request::METHOD_PATCH], $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function delete(string $uri, mixed $handler): self
    {
        return $this->add([Request::METHOD_DELETE], $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function head(string $uri, mixed $handler): self
    {
        return $this->addRoute([Request::METHOD_HEAD], $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function options(string $uri, mixed $handler): self
    {
        return $this->add([Request::METHOD_OPTIONS], $uri, $handler);
    }

    public function group(string $prefix, callable $callback): self
    {
        $previousGroupPrefix = $this->currentGroupPrefix;
        $this->currentGroupPrefix = $previousGroupPrefix . $prefix;
        $callback($this);
        $this->currentGroupPrefix = $previousGroupPrefix;

        return $this;
    }

    /**
     * @param array $methods
     * @param string $uri
     * @param mixed $handler
     * @return $this
     */
    public function add(array $methods, string $uri, mixed $handler)
    {
        foreach ($methods as $method) {
            $this->collection->add($method, $this->currentGroupPrefix . $uri, $handler);
        }

        return $this;
    }

    /**
     * @param Request $request
     * @return Route
     * @throws RouteNotFoundException
     */
    public function match(Request $request): Route
    {
        return $this->collection->match($request->getMethod(), $request->getUri());
    }

    /**
     * @param Request $request
     * @return void
     * @throws RouteNotFoundException
     * @throws Exception
     */
    // TODO: Refactoring
    public function dispatch(Request $request): Response
    {
        $route = $this->match($request);

        if (!$route) {
            throw new RouteNotFoundException("Route not found");
        }

        $callbackParameters = [];

        if ($route->getParameterNames() && preg_match($route->getPattern(), $request->getUri(), $matches) && $matches) {
            $variableValues = array_slice($matches, 1);

            if (count($variableValues) !== count($route->getParameterNames())) {
                throw new Exception("Route variables do not match.");
            }

            $callbackParameters = array_combine($route->getParameterNames(), $variableValues);
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
            $handler[0] = $this->container->make($handler[0]);
        }

        if (is_callable($handler)) {
            return $handler;
        }

        throw new Exception("Handler '$handler' not resolved.");
    }
}
