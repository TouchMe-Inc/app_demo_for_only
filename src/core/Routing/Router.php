<?php /** @noinspection ALL */

namespace Core\Routing;

use Core\Http\Request;
use Core\Routing\Exception\RouteNotFoundException;
use Exception;

class Router
{
    private RouteCollection $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
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
        $this->routes->add($route);

        return $this;
    }

    /**
     * @param Request $request
     * @return Route
     * @throws RouteNotFoundException
     */
    public function match(Request $request): Route
    {
        /** @var Route $route */
        foreach ($this->routes->getRoutesByMethod($request->getMethod()) as $route) {
            if ($route->compareUri($request->getUri())) {
                return $route;
            }
        }

        throw new RouteNotFoundException("Route not found");
    }
}
