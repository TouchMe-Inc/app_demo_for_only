<?php

namespace Core;

use Core\Bootstrap\BindApplication;
use Core\Bootstrap\BindConfiguration;
use Core\Bootstrap\BindContainer;
use Core\Bootstrap\HandleException;
use Core\Configuration\Configuration;
use Core\Container\Container;
use Core\Request\Request;
use Core\Routing\Dispatcher;
use Core\Routing\Router;
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

    private Configuration $configuration;

    private Router $router;

    private bool $runs = false;

    /**
     * Bootstrappers for the application.
     *
     * @var array
     */
    private array $bootstrappers = [
        BindApplication::class,
        BindContainer::class,
        BindConfiguration::class,
        HandleException::class,
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

    /**
     * Get the configuration associated with the application.
     *
     * @return Configuration
     */
    public function configuration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * Get the configuration associated with the application.
     *
     * @return Router
     */
    public function router(): Router
    {
        return $this->router;
    }

    public function run(): void
    {
        if ($this->runs) {
            return;
        }

        $request = Request::createFromGlobal();

        $this->container()->addInstance(Request::class, $request);

        $response = $this->router->dispatchRequest($request);

        $response->send();

        $this->runs = true;
    }

    public function getBasePath($path = ''): string
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param array $bootstrappers
     * @return void
     */
    public function bootstrap(array $bootstrappers): void
    {
        foreach ($bootstrappers as $bootstrapper) {
            (new $bootstrapper)->bootstrap($this);
        }
    }

    private function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;

        $this->container = new Container();

        $this->configuration = new Configuration();

        $this->router = new Router($this->container);

        $this->bootstrap($this->bootstrappers);
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