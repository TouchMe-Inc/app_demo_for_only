<?php

namespace Core;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Core\Bootstrap\LoadConfiguration;
use Core\Bootstrap\SetExceptionHandler;
use Core\Container\Container;
use Core\Http\Request;
use Core\Routing\Dispatcher;
use Core\Routing\Router;
use Exception;

class Application
{
    /**
     * @var self|null
     */
    private static Application|null $instance;

    private string $basePath;

    private Container $container;

    /**
     * Bootstrappers for the application.
     * 
     * @var array
     */
    private array $bootstrappers = [
        LoadConfiguration::class,
        SetExceptionHandler::class
    ];

    public static function create(string $basePath = ''): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($basePath);
        }

        return self::$instance;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function handleRequest(Request $request): void
    {
        $router = $this->getContainer()->make(Router::class);
        $router->get("/signin", [AuthController::class, "signIn"]);
        $router->get("/", [HomeController::class, "index"]);

        $dispatcher = $this->getContainer()->make(Dispatcher::class);

        print_r($dispatcher->dispatch($request));
    }

    public function getConfigPath($path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
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

        $this->container = Container::getInstance();

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
        throw new Exception("Cannot unserialize a singleton");
    }
}