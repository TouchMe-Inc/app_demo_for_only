<?php

namespace Core\Request\interface;

interface Request
{
    public static function createFromGlobal(): static;

    public function getMethod(): string;

    public function getUri(): string;
}