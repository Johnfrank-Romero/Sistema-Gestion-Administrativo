<?php

    session_start();
    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Core\Container;
    use App\Services\AuthService;

    //Definir URL base//
    define('BASE_URL', '/Gestion_Administrativo/public/');

    //Inicializar contenedor de dependencias//
    $authController = Container::getAuthController();

    //Ruteador de URLs amigables//
    $request = str_replace('/Gestion_Administrativo/', '', $_SERVER['REQUEST_URI']);
    $request = ltrim($request, 'public/'); //Limpia si viene con public//
    $parts = explode('?', $request); 
    $route = trim($parts[0], '/');

    //Si la ruta es vacia, redirige a login//
    $view = $route ?: 'login';

    //Acciones//
    $action = $_GET['action'] ?? '';

    if ($action === 'login') {
        $authController->handleLogin();
    } elseif ($action === 'register') {
        $authController->handleRegister();
    }

    //Vistas//
    $viewPath = __DIR__ . "/../src/Views/";

    switch ($view) {
        case 'registro':
            include $viewPath . 'register.php';
            break;
        case 'dashboard':
            //Verificacion de sesion//
            if (!AuthService::isLoggedIn()) {
                header('Location: ' . BASE_URL . 'login');
                exit;
            }
            include $viewPath . 'dashboard.php';
            break;
        case 'login':
        default:
            include $viewPath . 'login.php';
            break;
    }
?>