<?php /** @noinspection PhpUnhandledExceptionInspection */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Core\Application;
use Core\Http\Request;
use Core\Routing\Router;

// Register Composer
require __DIR__ . '/../../vendor/autoload.php';

// Create application
$app = Application::create(dirname(__DIR__));

//Add routes
$router = $app->getContainer()->make(Router::class);
$router->get("/signin", [AuthController::class, "signIn"]);
$router->get("/", [HomeController::class, "index"]);

// Handle request
$app->handleRequest(Request::createFromGlobal());
