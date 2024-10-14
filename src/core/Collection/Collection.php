<?php

namespace Core\Collection;

use ArrayAccess;
use Countable;
use Traversable;

class Collection implements Countable, ArrayAccess
{

    /**
     * @var array
     */
    private array $items = [];

    /**
     * @param array $items
     * @return void
     */
    public function __construct(array $items = [])
    {
        if (!is_null($items)) {
            $this->items = $items;
        }
    }

    /**
     * Push an item onto the end of the collection.
     *
     * @param mixed $value
     * @return void
     */
    public function push(mixed $value): void
    {
        $this->items[] = $value;
    }

    /**
     * Push an item onto the beginning of the collection.
     *
     * @param mixed $value
     * @return void
     */
    public function unshift(mixed $value): void
    {
        array_unshift($this->items, $value);
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->offsetExists($offset) ? $this->items[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
}