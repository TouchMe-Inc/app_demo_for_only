<?php

namespace Core\Routing\Interface;

use Core\Request\Interface\Request as RequestInterface;
use Core\Response\Interface\Response as ResponseInterface;

interface RouteHandler
{
    public function handle(RequestInterface $request): ResponseInterface;
}