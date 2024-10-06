<?php

namespace Core\Config;

class Configuration implements Collection
{
    private array $items = [];

    /**
     * @param array $items
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null): mixed
    {
        return $this->items[$key] ?? $default;
    }

    /**
     * @param array|string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value = null): void
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            $this->items[$key] = $value;
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function prepend($key, $value): void
    {
        $array = $this->get($key);

        array_unshift($array, $value);

        $this->set($key, $array);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function push($key, $value): void
    {
        $array = $this->get($key);

        $array[] = $value;

        $this->set($key, $array);
    }

    /**
     * @param $key
     * @return void
     */
    public function unset($key): void
    {
        unset($this->items[$key]);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }
}