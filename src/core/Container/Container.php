<?php

namespace Core\Container;

use ReflectionClass;
use ReflectionException;

class Container
{
    private static Container $instance;

    /**
     * @var array
     */
    private array $instances = [];


    /**
     * Create singleton instance.
     *
     * @return Container
     */
    public static function getInstance(): Container
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }
}