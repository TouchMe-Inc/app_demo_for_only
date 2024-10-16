<?php

namespace Core\Request\Interface;

use Core\Session\interface\Session as SessionInterface;

interface Request
{
    /**
     * @return static
     */
    public static function createFromGlobal(): static;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getUri(): string;

    /**
     * Get the Session.
     *
     * @return SessionInterface
     */
    public function getSession(): SessionInterface;

    /**
     * Set the Session.
     *
     * @param SessionInterface $session
     * @return void
     */
    public function setSession(SessionInterface $session): void;

    /**
     * Whether the request contains a Session.
     *
     * @return bool
     */
    public function hasSession(): bool;
}