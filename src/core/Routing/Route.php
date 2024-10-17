<?php

namespace Core\Routing;

use Closure;
use Core\Routing\Interface\Route as RouteInterface;

class Route implements RouteInterface
{
    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string $pattern;

    /**
     * @var array
     */
    private array $parameterNames;

    /**
     * @var mixed
     */
    private Closure|array $handler;

    private array $middlewares;

    /**
     * Create route instance.
     *
     * @param string $method
     * @param string $uri
     * @param mixed $handler
     * @param array $middlewares
     */
    public function __construct(string $method, string $uri, Closure|array $handler, array $middlewares = [])
    {
        $this->setMethod($method);

        [$pattern, $parameters] = $this->parseUri($uri);

        $this->pattern = $pattern;

        $this->parameterNames = $parameters;

        $this->handler = $handler;

        $this->middlewares = $middlewares;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = strtoupper($method);
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return array
     */
    public function getParameterNames(): array
    {
        return $this->parameterNames;
    }

    /**
     * @return Closure|array
     */
    public function getHandler(): Closure|array
    {
        return $this->handler;
    }

    /**
     * @param string $method
     * @return bool
     */
    public function compareMethod(string $method): bool
    {
        return $this->getMethod() === $method;
    }

    /**
     * @param string $uri
     * @return bool
     */
    public function compareUri(string $uri): bool
    {
        if (preg_match($this->getPattern(), $uri) !== 1) {
            return false;
        }

        return true;
    }

    /**
     * @param string $uri
     * @return array
     */
    private function parseUri(string $uri): array
    {
        $pattern = '~' . $uri . '~';
        $parameters = [];

        if (preg_match_all('~{(.*?)}~', $uri, $matches) === 1) {
            $pattern = str_replace($matches[0], "([^/]+)", $pattern);
            $parameters = $matches[1];
        }

        return [$pattern, $parameters];
    }
}
