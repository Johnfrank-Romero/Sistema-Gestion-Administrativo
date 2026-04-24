<?php

    namespace App\Controllers;
    use App\DAO\UserDAO;
    use App\Models\User;
    use App\Services\AuthService;
    use InvalidArgumentException;

    class UserController {
        private UserDAO $userDao;

        public function __construct(UserDAO $userDao) {
            $this->userDao = $userDao;
        }

        //Lista usuarios (activos o no)//
        public function index(bool $active = true): void {
            $users = $active ? $this->userDao->getAllActive() : $this->userDao->getAllInactive();

            $content = $active 
                ? __DIR__ . '/../Views/users/index.php' 
                : __DIR__ . '/../Views/users/inactive.php';
                
            include __DIR__ . '/../Views/dashboard.php';
        }

        //Procesar creacion con contraseña temporal//
        public function store(): void {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

            try {
                $rawPassword = $this->generateStrongPassword();

                $user = new User(
                    email: $_POST['email'] ?? '',
                    password: $rawPassword, //El modelo se encarga de validarla y hashearla//
                    firstName: $_POST['firstName'] ?? '',
                    lastName: $_POST['lastName'] ?? '',
                    role: $_POST['role'] ?? User::ROLE_ADMIN,
                    isTemporaryPassword: true
                );

                if ($this->userDao->create($user)) {
                    $_SESSION['success'] = "Usuario creado. Contraseña temporal: <strong>{$rawPassword}</strong>";
                    header('Location: ' . BASE_URL . 'users');
                    exit;
                }
            } catch (\InvalidArgumentException $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: ' . BASE_URL . 'users/create');
                exit;
            }
        }

        public function activate(int $id): void {
            if ($this->userDao->restore($id)) {
                $_SESSION['success'] = "Usuario reactivado exitosamente.";
            } else {
                $_SESSION['error'] = "No se pudo reactivar el usuario.";
            }
            header('Location: ' . BASE_URL . 'users/inactive');
            exit;
        }

        //Soft delete en un usuario//
        public function delete(int $id): void {
            //Evitar que el Super Admin se borre a si mismo//
            if ($id === $_SESSION['user_id']) {
                $_SESSION['error'] = "No puedes eliminar tu propia cuenta de administrador.";
            } else {
                if ($this->userDao->softDelete($id)) {
                    $_SESSION['success'] = "Usuario inhabilitado correctamente.";
                } else {
                    $_SESSION['error'] = "No se pudo realizar la operación.";
                }
            }
            header('Location: ' . BASE_URL . 'users');
            exit;
        }

        //Generar contraseña temporal//
        public function resetPassword(int $id): void {
            $newTempPass = $this->generateStrongPassword();
            $hashedTempPass = password_hash($newTempPass, PASSWORD_BCRYPT);
            
            if ($this->userDao->updateToTemporaryPassword($id, $hashedTempPass)) {
                $_SESSION['success'] = "Contraseña restablecida. Nueva clave temporal: <strong>{$newTempPass}</strong>";
            } else {
                $_SESSION['error'] = "Error al resetear la contraseña.";
            }
            header('Location: ' . BASE_URL . 'users');
            exit;
        }

        private function generateStrongPassword(): string {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-+=";
            $pass = [];
            //Asegurar tener al menos uno para la validacion//
            $pass[] = 'A'; //Mayuscula//
            $pass[] = 'a'; //Minuscula//
            $pass[] = '1'; //Numero//
            $pass[] = '@'; //Simbolo//
            
            for ($i = 0; $i < 8; $i++) {
                $pass[] = $chars[random_int(0, strlen($chars) - 1)];
            }
            shuffle($pass);
            return implode('', $pass);
        }
    }
?>