<?php

namespace Core\Session\interface;

interface Session
{
    public function start(array $options = []): void;

    public function destroy(): void;
}