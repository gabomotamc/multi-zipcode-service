<?php
session_start();
require __DIR__."/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
use CoffeeCode\Router\Router;
$router = new Router($_ENV['APP_URL']);

require_once($_ENV['APP_ROUTES_PATH']."/web.php");
require_once($_ENV['APP_ROUTES_PATH']."/api-v1.php");

/*
 * Redirect all errors
*/

if ($router->error()) {
    $router->redirect("/api/v1/error/{$router->error()}");
}

$router->dispatch();