<?php

namespace Core\Request;

use Exception;
use const PHP_SESSION_ACTIVE;

class Session
{
    public function __construct()
    {
        session_register_shutdown();
    }

    /**
     * @param array $options
     * @return void
     * @throws Exception
     */
    public function start(array $options = []): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new Exception('Session is already started');
        }

        if (!session_start($options)) {
            throw new Exception('Session start failed');
        }
    }
}