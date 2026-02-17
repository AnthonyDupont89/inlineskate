<?php

use App\Controllers\PageController;
use App\Controllers\AuthController;
use App\Controllers\LessonController;

$router->get('/', [PageController::class, 'home']);
$router->get('/courses', [PageController::class, 'courses']);
$router->get('/about', [PageController::class, 'about']);

$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'registerForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/agenda', [LessonController::class, 'agenda']);
$router->post('/agenda/store', [LessonController::class, 'store']);
$router->post('/agenda/enroll', [LessonController::class, 'enroll']);
$router->post('/agenda/cancel', [LessonController::class, 'cancel']);
