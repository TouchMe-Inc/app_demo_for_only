<?php

use Core\Application;
use Core\Http\Request;

// Register Composer
require __DIR__ . '/../../vendor/autoload.php';

// Use magic
$app = new Application();
$app->handleRequest(Request::createFromGlobal());
