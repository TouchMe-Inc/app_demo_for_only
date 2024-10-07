<?php /** @noinspection PhpUnhandledExceptionInspection */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Core\Application;
use Core\Http\Request;
use Core\Routing\Router;

// Redirect all requests that end with "/"
if ($_SERVER['REQUEST_URI'] != "/" && str_ends_with($_SERVER['REQUEST_URI'], '/')) {
    header('Location: ' . substr($_SERVER['REQUEST_URI'], 0, -1), true, 301);
    exit();
}

// Register Composer
require __DIR__ . '/../../vendor/autoload.php';

// Create application
$app = Application::create(dirname(__DIR__));

//Add routes
$router = $app->getContainer()->make(Router::class);
$router->get("/signin", [AuthController::class, "signIn"]);
$router->get("/", [HomeController::class, "index"]);

// Handle the request
$app->handleRequest(Request::createFromGlobal());
