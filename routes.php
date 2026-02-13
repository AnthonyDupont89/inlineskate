<?php

use App\Controllers\PageController;
use App\Controllers\AuthController;
use App\Controllers\SeanceController;

$router->get('/', [PageController::class, 'home']);
$router->get('/cours', [PageController::class, 'cours']);
$router->get('/about', [PageController::class, 'about']);

$router->get('/connexion', [AuthController::class, 'loginForm']);
$router->post('/connexion', [AuthController::class, 'login']);
$router->get('/inscription', [AuthController::class, 'registerForm']);
$router->post('/inscription', [AuthController::class, 'register']);
$router->get('/deconnexion', [AuthController::class, 'logout']);

$router->get('/agenda', [SeanceController::class, 'agenda']);
$router->post('/agenda/creer', [SeanceController::class, 'creer']);
$router->post('/agenda/inscrire', [SeanceController::class, 'inscrire']);
$router->post('/agenda/annuler', [SeanceController::class, 'annuler']);