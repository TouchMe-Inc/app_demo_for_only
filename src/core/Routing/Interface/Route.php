<?php

namespace Core\Routing\Interface;

use Core\Routing\Interface\RouteHandler as RouteHandlerInterface;

interface Route
{
    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getPattern(): string;

    /**
     * @param string $method
     * @return bool
     */
    public function compareMethod(string $method): bool;

    /**
     * @param string $uri
     * @return bool
     */
    public function compareUrl(string $uri): bool;

    /**
     * @return RouteHandler
     */
    //public function getHandler(): RouteHandlerInterface;
}