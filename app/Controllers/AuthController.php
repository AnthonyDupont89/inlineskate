<?php

namespace App\Controllers;
use App\Models\User;

class AuthController extends Controller
{
  public function loginForm(): string
  {
    return $this->view('auth/login');
  }

  public function login(): string
  {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = User::findByEmail($email);

    if (!$user || !password_verify($password, $user['password'])) {
      return $this->view('auth/login', ['error' => 'Email ou mot de passe incorrect.']);
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role'] = $user['role'];

    $this->redirect('/agenda');
  }

  public function registerForm(): string
  {
    return $this->view('auth/register');
  }

  public function register(): string
  {
    $email = $_POST['email'] ?? '';

    if (User::emailExists($email)) {
      return $this->view('auth/register', ['error' => 'Cet email est déjà utilisé.']);
    }

    User::create([
      'email' => $email,
      'password' => password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT),
      'firstName' => $_POST['first_name'] ?? '',
      'lastName' => $_POST['last_name'] ?? '',
      'address' => $_POST['address'] ?? '',
      'postalCode' => $_POST['postal_code'] ?? '',
      'city' => $_POST['city'] ?? '',
      'phone' => $_POST['phone'] ?? '',
      'role' => $_POST['role'] ?? 'student',
    ]);

    $this->redirect('/login');
  }

  public function logout(): never
  {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
      );
    }

    session_destroy();

    $this->redirect('/');
  }
}