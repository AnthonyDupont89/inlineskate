<?php

namespace App;

class Router
{
  private array $routes = [];

  public function get(string $uri, array $action): void
  {
    $this->routes['GET'][$uri] = $action;
  }

  public function post(string $uri, array $action): void
  {
    $this->routes['POST'][$uri] = $action;
  }

  public function resolve(string $uri, string $method): mixed
  {
    $action = $this->routes[$method][$uri] ?? null;

    if (!$action) {
      http_response_code(404);
      return '404 - Page non trouvée';
    }

    [$controller, $methodName] = $action;
    $controllerInstance = new $controller();
    return $controllerInstance->$methodName();
  }
}