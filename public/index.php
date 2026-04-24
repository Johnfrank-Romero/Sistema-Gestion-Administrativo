<?php

    session_start();
    require_once __DIR__ . '/../vendor/autoload.php';

    use App\Core\Container;
    use App\Services\AuthService;

    define('BASE_URL', '/Gestion_Administrativo/public/');

    //Inicializar controladores//
    $authController = Container::getAuthController();
    $userController = Container::getUserController();
    $ownerController = Container::getOwnerController();

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
            case 'update-password':
                $authController->handleChangePassword();
                break;
            case 'users/store':
                $userController->store();
                break;
            case 'owners/store': 
                $ownerController->store();
                break;
            case 'owners/update':
                $ownerController->update((int)$_POST['id']);
                break;
            case 'rates/update':
                $rate = $_POST['rate_value'] ?? null;
                if ($rate) {
                    $currencyService = Container::getCurrencyService();
                    $currencyService->saveRate($rate, $_SESSION['user_id']);
                    $_SESSION['success'] = "Tasa de cambio establecida en " . $rate . " Bs.";
                }
                header('Location: ' . BASE_URL . 'dashboard');
                break;
        }
        exit;
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

            if (isset($_SESSION['must_change_password']) && $_SESSION['must_change_password'] === true) {
                $_SESSION['error'] = "Acceso denegado. Debes actualizar tu contraseña temporal primero.";
                header('Location: ' . BASE_URL . 'change-password');
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

        case 'users':
            //Seguridad: Solo el Super Admin gestiona usuarios//
            if (!AuthService::isLoggedIn() || !AuthService::isSuperAdmin()) {
                $_SESSION['error'] = "Acceso denegado.";
                header('Location: ' . BASE_URL . 'dashboard');
                exit;
            }

            if (isset($_SESSION['must_change_password']) && $_SESSION['must_change_password'] === true) {
                $_SESSION['error'] = "Acceso denegado. Debes actualizar tu contraseña temporal primero.";
                header('Location: ' . BASE_URL . 'change-password');
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

        case 'owners': 
            if (!AuthService::isLoggedIn()) {
                header('Location: ' . BASE_URL . 'login');
                exit;
            }

            switch ($subAction) {
                case 'create':
                    $content = $viewPath . 'owners/register.php';
                    include $viewPath . 'dashboard.php';
                    break;
                case 'edit':
                    if ($id) $ownerController->edit((int)$id);
                    break;
                case 'delete':
                    //Solo Super_Admin puede hacer esta accion//
                    if (!AuthService::isSuperAdmin()) {
                        $_SESSION['error'] = "No tienes permisos para eliminar propietarios.";
                        header('Location: ' . BASE_URL . 'owners');
                        exit;
                    }
                    if ($id) $ownerController->delete((int)$id);
                    break;
                default:
                    $ownerController->index();
                    break;
            }
            break;

        case 'logout':
            $authController->handleLogout();
            break;

        default:
            $errorController = new \App\Controllers\ErrorController();
            $errorController->notFound();
            break;
    }
?>