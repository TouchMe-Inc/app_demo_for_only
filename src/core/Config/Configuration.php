<?php

namespace Core\Config;

class Configuration
{
    private array $items;

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
    public function has(string $key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->items[$key] ?? $default;
    }

    /**
     * @param array|string $key
     * @param mixed|null $value
     * @return void
     */
    public function set(array|string $key, mixed $value = null): void
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
    public function prepend(string $key, mixed $value): void
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
    public function push(string $key, mixed $value): void
    {
        $array = $this->get($key);

        $array[] = $value;

        $this->set($key, $array);
    }

    /**
     * @param string $key
     * @return void
     */
    public function unset(string $key): void
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