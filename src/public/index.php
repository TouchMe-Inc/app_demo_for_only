<?php /** @noinspection PhpUnhandledExceptionInspection */

use App\Bootstrap\CreateDatabaseConnection;
use App\Bootstrap\LoadConfiguration;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use Core\Application;
use Core\Routing\Router;

// Register Composer
require __DIR__ . '/../../vendor/autoload.php';

// Create application
$app = Application::create(dirname(__DIR__));

// Add routes
/** @var Router $router */
$router = $app->container()->make(Router::class);
$router
    ->get("/users/{id}", [UserController::class, "view"])
    ->get("/users", [UserController::class, "index"])
    ->get("/signin", [AuthController::class, "signIn"])
    ->post("/signin", [AuthController::class, "signIn"])
    ->post("/signup", [AuthController::class, "signUp"])
    ->get("/signup", [AuthController::class, "signUp"])
    ->get("/signout", [AuthController::class, "signOut"])
    ->get("/", [HomeController::class, "index"]);

// Bootstrap the Application
$app->bootstrap([
    LoadConfiguration::class,
    CreateDatabaseConnection::class
]);

// Run the Application
$app->run();
