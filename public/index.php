<?php

    session_start();
    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Core\Container;
    use App\Services\AuthService;

    //Inicializar contenedor de dependencias//
    $authController = Container::getAuthController();

    //Acciones//
    $action = $_GET['action'] ?? '';

    if ($action === 'login') {
        $authController->handleLogin();
    } elseif ($action === 'register') {
        $authController->handleRegister();
    }

    //Vistas//
    $view = $_GET['view'] ?? 'login';
    $viewPath = __DIR__ . "/../src/Views/";

    switch ($view) {
        case 'registro':
            include $viewPath . 'register.php';
            break;
        case 'dashboard':
            //Verificacion de sesion//
            if (!AuthService::isLoggedIn()) {
                header('Location: index.php?view=login');
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