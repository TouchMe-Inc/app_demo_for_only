<?php /** @noinspection PhpUnhandledExceptionInspection */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Core\Application;
use Core\Http\Request;
use Core\Routing\Router;

// Register Composer
require __DIR__ . '/../../vendor/autoload.php';

// Create application
$app = Application::create(dirname(__DIR__));

//Add routes
$router = $app->getContainer()->make(Router::class);
$router->get("/users", [UserController::class, "index"]);
$router->get("/signin", [AuthController::class, "signIn"]);
$router->get("/signup", [AuthController::class, "signUp"]);
$router->get("/", [HomeController::class, "index"]);

// Handle request
$app->handleRequest(Request::createFromGlobal());
