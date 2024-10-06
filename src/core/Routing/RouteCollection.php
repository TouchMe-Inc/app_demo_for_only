<?php

namespace Core\Routing;

use ArrayIterator;
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
     * @param Route $route
     * @return void
     */
    public function add(Route $route): void
    {
        $method = $route->getMethod();
        $this->routes[] = $route;
        $this->routesByMethod[$method][] = $route;
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