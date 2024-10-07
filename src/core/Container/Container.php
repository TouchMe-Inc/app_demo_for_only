<?php

namespace Core\Container;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

class Container
{
    /**
     * @var self|null
     */
    private static Container|null $instance = null;

    /**
     * @var array
     */
    private array $instances = [];

    /**
     * Create singleton instance.
     *
     * @return Container
     */
    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    /**
     * @param string $className
     * @return mixed|object|null
     * @throws ReflectionException
     */
    public function make(string $className): mixed
    {
        if ($this->hasInstance($className)) {
            return $this->instances[$className];
        }

        $object = $this->build($className);

        $this->instances[$className] = $object;

        return $object;
    }

    /**
     * @param string $className
     * @return bool
     */
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

        $arguments = $this->prepareArguments($dependencies);

        return $reflector->newInstanceArgs($arguments);
    }

    /**
     * @param array $dependencies
     * @return array
     * @throws ReflectionException
     * @throws Exception
     */
    private function prepareArguments(array $dependencies): array
    {
        $arguments = [];

        foreach ($dependencies as $dependency) {
            $arguments[] = $dependency->getType()->isBuiltin() ? $this->prepareBuiltin($dependency) : $this->prepareNotBuiltin($dependency);
        }

        return $arguments;
    }

    /**
     * @throws Exception
     */
    private function prepareBuiltin(ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new Exception("Parameter '{$parameter->getName()}' in class '{$parameter->getDeclaringClass()->getName()}' unresolvable");
    }

    /**
     * @throws ReflectionException
     */
    private function prepareNotBuiltin(ReflectionParameter $parameter)
    {
        if ($parameter->isOptional()) {
            return $parameter->getDefaultValue();
        }

        $className = $parameter->getType()->getName();

        return $this->make($className);
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton");
    }
}