<?php

namespace Core\Request\Interface;

interface Request
{
    public static function createFromGlobal(): static;

    public function getMethod(): string;

    public function getUri(): string;
}