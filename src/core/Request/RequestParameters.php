<?php

namespace Core\Request;

class RequestParameters
{
    private array $parameters = [];

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        foreach ($parameters as $name => $value) {
            $this->set($name, $value);
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->parameters[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed|null $value
     * @return void
     */
    public function set(string $key, mixed $value = null): void
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @param string $key
     * @return void
     */
    public function unset(string $key): void
    {
        unset($this->parameters[$key]);
    }
}