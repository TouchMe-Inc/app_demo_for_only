<?php

namespace App\Mappers;

use Exception;
use ReflectionClass;
use ReflectionException;

abstract class Mapper
{
    protected abstract static function model(): string;

    /**
     * @param array $data
     * @param array $options
     * @return mixed
     * @throws Exception
     */
    public static function toObject(array $data, array $options = []): mixed
    {
        $className = static::model();

        try {
            $reflector = new ReflectionClass($className);
        } catch (ReflectionException $e) {
            throw new Exception("Class '$className' does not exist.", 0, $e);
        }

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class '{$className}' is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (!is_null($constructor)) {
            $dependencies = $constructor->getParameters();

            if (count($dependencies)) {
                throw new Exception("Class '{$className}' has dependencies.");
            }
        }

        foreach ($options as $newKey => $oldKey) {
            if (array_key_exists($oldKey, $data)) {
                $data[$newKey] = $data[$oldKey];
                unset($data[$oldKey]);
            }
        }

        $object = $reflector->newInstance();

        $properties = $reflector->getProperties();

        $fields = [];

        foreach ($properties as $property) {
            $fields[$property->getName()] = $property;
        }

        foreach ($data as $key => $value) {
            if (isset($fields[$key])) {
                $fields[$key]->setValue($object, $value);
            }
        }

        return $object;
    }
}