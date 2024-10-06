<?php

namespace Core\Container;

use Exception;
use ReflectionClass;
use ReflectionException;

class Container
{
    /**
     * @var self
     */
    private static $instance;

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

    /**
     * @throws ReflectionException
     */
    public function make(string $className)
    {
        if ($this->hasInstance($className)) {
            return $this->instances[$className];
        }

        $object = $this->build($className);

        $this->instances[$className] = $object;

        return $object;
    }

    public function hasInstance(string $className): bool
    {
        return isset($this->instances[$className]);
    }

    /**
     * @param string $className
     * @param mixed $instance
     * @return void
     */
    public function addInstance(string $className, mixed $instance): void
    {
        $this->instances[$className] = $instance;
    }

    /**
     * Remove a resolved instance from the instance cache.
     *
     * @param string $className
     * @return void
     */
    public function removeInstance(string $className): void
    {
        unset($this->instances[$className]);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    private function build($className)
    {
        $reflector = new ReflectionClass($className);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class {$className} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $className();
        }

        $dependencies = $constructor->getParameters();

        $arguments = [];

        foreach ($dependencies as $dependency) {
            $arguments[] = $dependency->getType()->isBuiltin() ? $this->prepareBuiltin($dependency) : $this->prepareNotBuiltin($dependency);
        }

        return $reflector->newInstanceArgs($arguments);
    }

    /**
     * @throws Exception
     */
    private function prepareBuiltin(\ReflectionParameter $parameter)
    {
        var_dump("resolveBuiltin");
        if ($parameter->isDefaultValueAvailable()) {

            return $parameter->getDefaultValue();
        }

        throw new Exception("Default value for parameter {$parameter->getName()} is not defined");
    }

    /**
     * @throws ReflectionException
     */
    private function prepareNotBuiltin(\ReflectionParameter $parameter)
    {
        if ($parameter->isOptional()) {
            return $parameter->getDefaultValue();
        }

        $className = $parameter->getType()->getName();

        return $this->make($className);
    }
}