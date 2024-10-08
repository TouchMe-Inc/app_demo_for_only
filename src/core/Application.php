<?php

namespace Core;

use Core\Bootstrap\BindApplication;
use Core\Bootstrap\CreateDatabaseConnection;
use Core\Bootstrap\LoadConfiguration;
use Core\Bootstrap\HandleException;
use Core\Container\Container;
use Core\Http\Request;
use Core\Routing\Dispatcher;
use Exception;

class Application
{
    /**
     * @var self|null
     */
    private static self|null $instance = null;

    /**
     * Path to the src directory.
     *
     * @var string
     */
    private string $basePath;

    private Container $container;

    /**
     * Bootstrappers for the application.
     *
     * @var array
     */
    private array $bootstrappers = [
        BindApplication::class,
        HandleException::class,
        LoadConfiguration::class,
        CreateDatabaseConnection::class
    ];

    /**
     * @throws Exception
     */
    public static function create(string $basePath = ''): self
    {
        if (is_null(self::$instance)) {
            return self::$instance = new self($basePath);
        }

        throw new Exception("Application already initialized.");
    }

    /**
     * @throws Exception
     */
    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            throw new Exception("Application needs to be initialized.");
        }

        return self::$instance;
    }

    /**
     * Get the container associated with the application.
     *
     * @return Container
     */
    public function container(): Container
    {
        return $this->container;
    }

    public function handleRequest(Request $request): void
    {
        $dispatcher = $this->container()->make(Dispatcher::class);

        print_r($dispatcher->dispatch($request));
    }

    public function getBasePath($path = ''): string
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function getConfigPath($path = ''): string
    {
        return $this->getBasePath('config' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }

    private function bootstrap(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            (new $bootstrapper())->bootstrap($this);
        }
    }

    private function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;

        $this->container = new Container();

        $this->bootstrap();
    }

    private function __clone()
    {
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }
}