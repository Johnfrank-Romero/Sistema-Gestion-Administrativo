<?php

    namespace App\Controllers;
    use App\Services\AuthService;
    use App\DAO\UserDAO;

    class AuthController {
        private AuthService $authService;
        private UserDAO $userDao;

        public function __construct(AuthService $authService, UserDAO $userDao) {
            $this->authService = $authService;
            $this->userDao = $userDao;
        }
    
        //Maneja la peticion de inicio de sesion desde el formulario//
        public function handleLogin(): void {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ' . BASE_URL . 'login');
                exit;
            }

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = $this->authService->login($email, $password);

            if ($user) {
                //Si tiene contraseña temporal, obliga ir a cambio de clave//
                if ($user->isTemporaryPassword) {
                    header('Location: ' . BASE_URL . 'change-password');
                } else {
                    header('Location: ' . BASE_URL . 'dashboard');
                }
                exit;
            } else {
                $_SESSION['error'] = "Credenciales incorrectas o cuenta inhabilitada.";
                header('Location: ' . BASE_URL . 'login');
                exit;
            }
        }

        //Solo el Super Admin puede acceder a esta ruta//
        public function handleUserCreation(): void {
            if (!AuthService::isSuperAdmin()) {
                $_SESSION['error'] = "No tienes permisos para esta acción.";
                header('Location: ' . BASE_URL . 'dashboard');
                exit;
            }
        }

        public function handleLogout(): void {
            AuthService::logout();
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        public function handleChangePassword() {
            //Verificar metodo y datos//
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ' . BASE_URL . 'change-password');
                exit;
            }

            $newPass = $_POST['new_password'] ?? '';
            $confirmPass = $_POST['confirm_password'] ?? '';

            if (empty($newPass) || $newPass !== $confirmPass) {
                $_SESSION['error'] = "Las contraseñas no coinciden.";
                header('Location: ' . BASE_URL . 'change-password');
                exit;
            }

            try {
                //Validacion del Modelo//
                \App\Models\User::validatePasswordSecurity($newPass);

                $userId = $_SESSION['user_id'] ?? null;
                if (!$userId) throw new \Exception("Sesión inválida. Reintente de nuevo.");
                $hashedPass = password_hash($newPass, PASSWORD_BCRYPT);

                if ($this->userDao->updatePassword($userId, $hashedPass)) {
                    //Limpiar datos sensibles pero se mantiene el mensaje//
                    $successMsg = "Contraseña actualizada con éxito. Inicia sesión.";
                    unset($_SESSION['user_id'], $_SESSION['user_role'], $_SESSION['must_change_password']);
                    
                    $_SESSION['success'] = $successMsg;
                    header('Location: ' . BASE_URL . 'login');
                    exit;
                } else {
                    throw new \Exception("No se pudo actualizar la base de datos.");
                }

            } catch (\InvalidArgumentException $e) {
                //Captura los errores de validacion (JSON)//
                $_SESSION['error'] = $e->getMessage();
                header('Location: ' . BASE_URL . 'change-password');
                exit;
            } catch (\Exception $e) {
                //Captura errores generales//
                $_SESSION['error'] = $e->getMessage();
                header('Location: ' . BASE_URL . 'change-password');
                exit;
            }
        }
    }
?>