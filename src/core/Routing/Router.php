<?php /** @noinspection ALL */

namespace Core\Routing;

use Core\Request\Request;
use Core\Routing\Exception\RouteNotFoundException;

class Router
{
    private RouteCollection $collection;

    public function __construct(RouteCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function get(string $uri, mixed $handler): self
    {
        return $this->addRoute(Request::METHOD_GET, $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    public function post(string $uri, mixed $handler): self
    {
        return $this->addRoute(Request::METHOD_POST, $uri, $handler);
    }


    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     */
    public function put(string $uri, mixed $handler): self
    {
        return $this->addRoute(Request::METHOD_PUT, $uri, $handler);
    }


    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     */
    public function patch(string $uri, mixed $handler): self
    {
        return $this->addRoute(Request::METHOD_PATCH, $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     */
    public function delete(string $uri, mixed $handler): self
    {
        return $this->addRoute(Request::METHOD_DELETE, $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     */
    public function head(string $uri, mixed $handler): self
    {
        return $this->addRoute(Request::METHOD_HEAD, $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     */
    public function options(string $uri, mixed $handler): self
    {
        return $this->addRoute(Request::METHOD_OPTIONS, $uri, $handler);
    }


    /**
     * @param string $method
     * @param string $uri
     * @param mixed $handler
     * @return self
     */
    private function addRoute(string $method, string $uri, mixed $handler): self
    {
        $route = new Route($method, $uri, $handler);
        $this->collection->add($route);

        return $this;
    }

    /**
     * @param string $method
     * @param mixed $uri
     * @return Route
     * @throws RouteNotFoundException
     */
    public function match(string $method, mixed $uri): Route
    {
        $routesByMethod = $this->collection->getRoutesByMethod($method);

        /** @var Route $route */
        foreach ($routesByMethod as $route) {
            if ($route->compareUri($uri)) {
                return $route;
            }
        }

        throw new RouteNotFoundException("Route not found");
    }

    /**
     * @param Request $request
     * @return Route
     * @throws RouteNotFoundException
     */
    public function matchByRequest(Request $request): Route
    {
        return $this->match($request->getMethod(), $request->getUri());
    }
}
