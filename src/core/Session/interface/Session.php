<?php

namespace Core\Session\interface;

interface Session
{
    /**
     * @param array $options
     * @return void
     */
    public function start(array $options = []): void;

    /**
     * @return void
     */
    public function destroy(): void;

    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void;

    /**
     * @param string $key
     * @param $default
     * @return mixed
     */
    public function get(string $key, $default = null): mixed;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string $key
     * @return void
     */
    public function remove(string $key): void;

    /**
     * @param string $key
     * @return mixed
     */
    public function flash(string $key): mixed;
}