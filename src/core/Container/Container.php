<?php

namespace Core\Container;

use Core\Container\Exception\BuildClassException;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

class Container
{

    /**
     * @var array
     */
    private array $instances = [];

    /**
     * @param string $className
     * @return mixed|object|null
     * @throws BuildClassException
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
    public function bind(string $className, mixed $instance): void
    {
        $this->instances[$className] = $instance;
    }

    /**
     * Remove a resolved instance from the instance cache.
     *
     * @param string $className
     * @return void
     */
    public function forget(string $className): void
    {
        unset($this->instances[$className]);
    }

    /**
     * @param string $className
     * @return mixed|object|null
     * @throws BuildClassException
     */
    private function build(string $className): mixed
    {
        try {
            $reflector = new ReflectionClass($className);
        } catch (ReflectionException $e) {
            throw new BuildClassException("Class '$className' does not exist.", 0, $e);
        }

        if (!$reflector->isInstantiable()) {
            throw new BuildClassException("Class '{$className}' is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) try {
            return $reflector->newInstance();
        } catch (ReflectionException $e) {
            throw new BuildClassException($e->getMessage(), 0, $e);
        }

        $dependencies = $constructor->getParameters();

        $arguments = $this->prepareArguments($dependencies);

        try {
            return $reflector->newInstanceArgs($arguments);
        } catch (ReflectionException $e) {
            throw new BuildClassException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param array $dependencies
     * @return array
     * @throws BuildClassException
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
     * @param ReflectionParameter $parameter
     * @return mixed
     * @throws BuildClassException
     */
    private function prepareBuiltin(ReflectionParameter $parameter): mixed
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        if ($parameter->hasType() && $parameter->allowsNull()) {
            return null;
        }

        throw new BuildClassException("Parameter '{$parameter->getName()}' in class '{$parameter->getDeclaringClass()->getName()}' unresolvable.");
    }

    /**
     * @param ReflectionParameter $parameter
     * @return mixed
     * @throws BuildClassException
     */
    private function prepareNotBuiltin(ReflectionParameter $parameter): mixed
    {
        try {
            return $this->make($parameter->getType()->getName());
        } catch (BuildClassException $e) {
            if ($parameter->isOptional()) try {
                return $parameter->getDefaultValue();
            } catch (ReflectionException $e) {
                throw new BuildClassException($e->getMessage(), 0, $e);
            }

            throw $e;
        }
    }
}