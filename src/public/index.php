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
/** @var Router $router */
$router = $app->container()->make(Router::class);
$router
    ->get("/users", [UserController::class, "index"])
    ->get("/signin", [AuthController::class, "signIn"])
    ->get("/signup", [AuthController::class, "signUp"])
    ->get("/signout", [AuthController::class, "signOut"])
    ->get("/", [HomeController::class, "index"]);

// Handle request
$app->handleRequest(Request::createFromGlobal());
