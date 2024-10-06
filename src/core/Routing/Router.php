<?php /** @noinspection ALL */

namespace Core\Routing;

use Core\Http\Request;
use Exception;

class Router
{
    private RouteCollection $routes;

    public function __construct()
    {
        $this->routes = new RouteCollection();
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     * @throws Exception
     */
    public function get(string $uri, mixed $handler): void
    {
        $this->addRoute(Request::METHOD_GET, $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     * @throws Exception
     */
    public function post(string $uri, mixed $handler): void
    {
        $this->addRoute(Request::METHOD_POST, $uri, $handler);
    }


    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     * @throws Exception
     */
    public function put(string $uri, mixed $handler): void
    {
        $this->addRoute(Request::METHOD_PUT, $uri, $handler);
    }


    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     * @throws Exception
     */
    public function patch(string $uri, mixed $handler): void
    {
        $this->addRoute(Request::METHOD_PATCH, $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     * @throws Exception
     */
    public function delete(string $uri, mixed $handler): void
    {
        $this->addRoute(Request::METHOD_DELETE, $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     * @throws Exception
     */
    public function head(string $uri, mixed $handler): void
    {
        $this->addRoute(Request::METHOD_HEAD, $uri, $handler);
    }

    /**
     * @param string $uri
     * @param mixed $handler
     * @return void
     * @throws Exception
     */
    public function options(string $uri, mixed $handler): void
    {
        $this->addRoute(Request::METHOD_OPTIONS, $uri, $handler);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param mixed $handler
     * @return void
     * @throws Exception
     */
    private function addRoute(string $method, string $uri, mixed $handler): void
    {
        $route = new Route($method, $uri, $handler);
        $this->routes->add($route);
    }

    /**
     * @param Request $request
     * @return Route
     * @throws Exception
     */
    public function match(Request $request): Route
    {
        /** @var Route $route */
        foreach ($this->routes->getRoutesByMethod($request->getMethod()) as $route) {
            if ($route->compareUri($request->getUri())) {
                return $route;
            }
        }

        throw new Exception("No route matched");
    }
}
