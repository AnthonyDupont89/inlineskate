<?php

namespace App\Controllers;

class Controller
{
  protected function view(string $name, array $data = []): string
  {
    extract($data);

    ob_start();
    require __DIR__ . '/../../views/' . $name . '.php';
    return ob_get_clean();
  }

  protected function redirect(string $url): never
  {
    header("Location: $url");
    exit;
  }
}