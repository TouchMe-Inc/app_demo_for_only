<?php

use Core\Application;
use Core\Http\Request;

// Redirect all requests that end with "/"
if ($_SERVER['REQUEST_URI'] != "/" && str_ends_with($_SERVER['REQUEST_URI'], '/')) {
    header('Location: ' . substr($_SERVER['REQUEST_URI'], 0, -1), true, 301);
    exit();
}

// Register Composer
require __DIR__ . '/../../vendor/autoload.php';

// Use magic
$app = new Application();
$app->handleRequest(Request::createFromGlobal());
