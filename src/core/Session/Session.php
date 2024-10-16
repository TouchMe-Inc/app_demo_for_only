<?php

namespace Core\Session;

use Core\Session\interface\Session as SessionInterface;
use Exception;
use const PHP_SESSION_ACTIVE;

class Session implements SessionInterface
{
    public function __construct()
    {
        session_register_shutdown();
    }

    public function start(array $options = []): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new Exception('Session is already started');
        }

        if (!session_start($options)) {
            throw new Exception('Session start failed');
        }
    }

    public function destroy(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return;
        }

        if (!session_destroy()) {
            throw new Exception('Session destroy failed');
        }
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function flash(string $key): mixed
    {
        $value = $this->get($key);
        $this->remove($key);
        return $value;
    }
}