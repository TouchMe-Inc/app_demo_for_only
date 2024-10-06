<?php

namespace Core\Config;

interface Collection
{
    public function has($key);

    public function get($key, $default = null);

    public function set($key, $value = null);

    public function prepend($key, $value);

    public function push($key, $value);

    public function unset($key);

    public function all();
}