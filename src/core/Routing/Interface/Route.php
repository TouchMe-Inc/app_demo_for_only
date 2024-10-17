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
     * @return RouteHandler
     */
    //public function getHandler(): RouteHandlerInterface;
}