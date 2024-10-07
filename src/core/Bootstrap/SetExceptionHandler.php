<?php

namespace Core\Bootstrap;

use Core\Application;
use Core\Bootstrap\Interface\Bootstrapper;
use Core\Exceptions\ExceptionHandler;
use ErrorException;
use Throwable;

class SetExceptionHandler implements Bootstrapper
{

    private Application $app;

    public function bootstrap(Application $app): void
    {
        $this->app = $app;

        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, "handleError"]);
    }

    public function handleException(Throwable $e): void
    {
        $this->app->getContainer()->make(ExceptionHandler::class)->handle($e);
    }

    /**
     * @param int $level
     * @param string $message
     * @param string $fileName
     * @param int $line
     * @return void
     * @throws ErrorException
     */
    public function handleError(int $level, string $message, string $fileName, int $line): void
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $fileName, $line);
        }
    }
}