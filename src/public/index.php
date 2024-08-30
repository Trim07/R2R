<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/bootstrap.php';
require_once __DIR__ . '/../Utils/Helper.php';

//function isLoggedIn(): bool
//{
//    return isset($_SESSION['user_id']);
//}
//
//// Verifica se o usuário está tentando acessar a página de login ou registro
//$request_uri = $_SERVER['REQUEST_URI'];
//
//// Redireciona para a página de login se o usuário não estiver autenticado e a URL não for login.php ou register.php
//if (!isLoggedIn() && !in_array($request_uri, ['/login.php', '/register.php'])) {
//    header('Location: /login.php');
//    exit();
//}
//
//// Permite o acesso a login.php e register.php sem verificar o login
//if ($request_uri == '/login.php' || $request_uri == '/register.php') {
////    include __DIR__ . $request_uri;
//} else {
//    header('Location: /customers/index.php');
//}