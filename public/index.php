<?php

require_once __DIR__ . '/../bootstrap.php';

$router = new App\Router();

require_once __DIR__ . '/../routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

echo $router->resolve($uri, $method);
