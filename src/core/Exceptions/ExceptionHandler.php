<?php

namespace Core\Exceptions;

use Throwable;

class ExceptionHandler
{
    /**
     * @param Throwable $exception
     * @return void
     */
    public function handle(Throwable $exception): void
    {
        print_r("Handled: " . $exception->getMessage());
    }
}