<?php

namespace Core\Routing;

use ArrayIterator;
use Core\Routing\Exception\RouteNotFoundException;
use Countable;
use IteratorAggregate;

class RouteCollection implements Countable, IteratorAggregate
{
    /**
     * @var array
     */
    private array $routes = [];

    /**
     * @var array
     */
    private array $routesByMethod = [];

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return array_values($this->routes);
    }

    /**
     * @param string $method
     * @return array
     */
    public function getRoutesByMethod(string $method): array
    {
        return $this->routesByMethod[$method] ?? [];
    }

    /**
     * @param string $method
     * @param mixed $uri
     * @param $handler
     * @return void
     */
    public function add(string $method, string $uri, mixed $handler): void
    {
        $route = new Route($method, $uri, $handler);
        $this->routes[] = $route;
        $this->routesByMethod[$method][] = $route;
    }

    /**
     * @param string $method
     * @param mixed $uri
     * @return Route
     * @throws RouteNotFoundException
     */
    public function match(string $method, mixed $uri): Route
    {
        $routesByMethod = $this->getRoutesByMethod($method);

        /** @var Route $route */
        foreach ($routesByMethod as $route) {
            if ($route->compareUri($uri)) {
                return $route;
            }
        }

        throw new RouteNotFoundException("Route not found");
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->getRoutes());
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->getRoutes());
    }
}