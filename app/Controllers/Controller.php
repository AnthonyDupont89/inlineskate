<?php

namespace App\Controllers;

class Controller
{
  protected function view(string $name, array $data = []): string
  {
    $data['csrfToken'] = $_SESSION['csrf_token'] ?? '';

    extract($data);

    ob_start();
    require __DIR__ . '/../../views/' . $name . '.php';
    $content = ob_get_clean();

    ob_start();
    require __DIR__ . '/../../views/layout.php';
    return ob_get_clean();
  }

  protected function redirect(string $url): never
  {
    header("Location: $url");
    exit;
  }

  protected function validate(array $data, array $rules): array
  {
    $errors = [];

    foreach ($rules as $field => $rule) {
      $value = trim($data[$field] ?? '');

      if (str_contains($rule, 'required') && $value === '') {
        $errors[$field] = 'Ce champ est obligatoire.';
        continue;
      }

      if (str_contains($rule, 'email') && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $errors[$field] = 'Adresse email invalide';
      }

      if (str_contains($rule, 'min:')) {
        preg_match('/min:(\d+)/', $rule, $matches);
        if(strlen($value) < (int)$matches[1]) {
          $errors[$field] = 'Minimum ' . $matches[1] . ' caractères requis.';
        }
      }

      if ($field === 'role' && !in_array($value, ['student', 'instructor'])) {
        $errors[$field] = 'Profil invalide';
      }
    }

    return $errors;
  }
}