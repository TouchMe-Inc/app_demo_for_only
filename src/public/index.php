<?php /** @noinspection PhpUnhandledExceptionInspection */

use App\Bootstrap\BindYandexSmartCaptcha;
use App\Bootstrap\CreateDatabaseConnection;
use App\Bootstrap\LoadConfiguration;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use Core\Application;
use Core\Request\Request;
use Core\Routing\Router;

// Register Composer
require __DIR__ . '/../../vendor/autoload.php';

// Create application
$app = Application::create(dirname(__DIR__));

// Set up router routes
$app->router()
    ->group('/users', function (Router $router) {
        $router->get("/{id}", [UserController::class, "view"]);
        $router->get("", [UserController::class, "index"]);
    })
    ->add(['GET', 'POST'], "/signin", [AuthController::class, "signIn"])
    ->add(['GET', 'POST'], "/signup", [AuthController::class, "signUp"])
    ->get("/signout", [AuthController::class, "signOut"])
    ->get("/", [HomeController::class, "index"]);

// Bootstrap application
$app->bootstrap([
    LoadConfiguration::class,
    CreateDatabaseConnection::class,
    BindYandexSmartCaptcha::class,
]);

// Handle request
$app->handleRequest(Request::createFromGlobal());
