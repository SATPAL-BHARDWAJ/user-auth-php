<?php

$Routes = [
    '/' => './resources/home.php',
    '/login' => './resources/auth/auth.php',
    '/signup' => './resources/auth/auth.php',

    '/app/login' => './app/auth/LoginController.php',
    '/app/signup' => './app/auth/RegisterController.php',
    '/logout' => './app/auth/LogoutController.php',
];