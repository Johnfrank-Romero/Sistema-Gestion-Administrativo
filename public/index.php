<?php

    session_start();
    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Core\Container;
    use App\Services\AuthService;

    define('BASE_URL', '/Gestion_Administrativo/public/');

    //Inicializar controladores//
    $authController = Container::getAuthController();
    $userController = Container::getUserController(); 

    $requestUri = $_SERVER['REQUEST_URI'];
    $basePath = '/Gestion_Administrativo/public/';

    $route = str_replace($basePath, '', $requestUri);
    $route = explode('?', $route)[0];
    $route = trim($route, '/');

    //Capturar sub-acciones//
    $parts = explode('/', $route);
    $mainRoute = $parts[0];
    $subAction = $parts[1] ?? null;
    $id = $parts[2] ?? null;

    //Acciones POST//
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch ($route) {
            case 'login':
                $authController->handleLogin();
                break;
            case 'users/store':
                $userController->store();
                break;
        }
    }

    //Vistas y Acciones GET//
    $viewPath = __DIR__ . "/../src/Views/";

    switch ($mainRoute) {
        case '':
        case 'login':
            if (AuthService::isLoggedIn()) {
                header('Location: ' . BASE_URL . 'dashboard');
                exit;
            }
            include $viewPath . 'login.php';
            break;

        case 'dashboard':
            if (!AuthService::isLoggedIn()) {
                $_SESSION['error'] = "Debes iniciar sesión primero.";
                header('Location: ' . BASE_URL . 'login');
                exit;
            }
            include $viewPath . 'dashboard.php';
            break;

        case 'change-password':
            if (!AuthService::isLoggedIn()) {
                header('Location: ' . BASE_URL . 'login');
                exit;
            }
            include $viewPath . 'auth/change-password.php';
            break;

        case 'update-password':
            $authController->handleChangePassword();
            break;

        case 'users':
            //Seguridad: Solo el Super Admin gestiona usuarios//
            if (!AuthService::isLoggedIn() || !AuthService::isSuperAdmin()) {
                $_SESSION['error'] = "Acceso denegado.";
                header('Location: ' . BASE_URL . 'dashboard');
                exit;
            }

            //Manejador de sub-rutas//
            switch ($subAction) {
                case 'create':
                    $content = $viewPath . 'users/register.php';
                    include $viewPath . 'dashboard.php';
                    break;
                case 'reset':
                    if ($id) $userController->resetPassword((int)$id);
                    break;
                case 'delete':
                    if ($id) $userController->delete((int)$id);
                    break;
                case 'inactive':
                    $userController->index(false); 
                    break;
                case 'activate':
                    if ($id) $userController->activate((int)$id);
                    break;
                default:
                    //Lista los activos por defecto//
                    $userController->index();
                    break;
            }
            break;

        case 'logout':
            $authController->handleLogout();
            break;

        default:
            http_response_code(404);
            include $viewPath . '404.php';
            break;
    }
?>