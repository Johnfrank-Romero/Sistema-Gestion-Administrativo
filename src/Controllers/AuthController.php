<?php

    namespace App\Controllers;
    use App\Services\AuthService;

    class AuthController {
        private AuthService $authService;

        public function __construct(AuthService $authService) {
            $this->authService = $authService;
        }
    
        //Maneja la petición de registro desde el formulario//
        public function handleRegister(): void {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: index.php?view=registro');
                exit;
            }

            try {
                $user = new \App\Models\User(
                    email: $_POST['email'] ?? '',
                    password: $_POST['password'] ?? '',
                    firstName: $_POST['firstName'] ?? '',
                    lastName: $_POST['lastName'] ?? ''
                );

                if ($this->authService->register($user)) {
                    $_SESSION['success'] = "Registro exitoso. Ahora puedes iniciar sesión.";
                    header('Location: index.php?view=login');
                    exit;
                }
            } catch (\InvalidArgumentException $e) {
                //Decodificar el JSON de errores//
                $decodedErrors = json_decode($e->getMessage(), true);
                
                if (is_array($decodedErrors)) {
                    $_SESSION['errors'] = $decodedErrors;
                } else {
                    $_SESSION['errors'] = [$e->getMessage()];
                }
                header('Location: index.php?view=registro');
                exit;
            } catch (\Exception $e) {
                $_SESSION['error'] = "Error inesperado, intente más tarde.";
                header('Location: index.php?view=registro');
                exit;
            }
        }
        //Maneja la peticion de inicio de sesion desde el formulario//
        public function handleLogin(): void {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: index.php?view=login');
                exit;
            }

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = $this->authService->login($email, $password);

            if ($user) {
                header('Location: index.php?view=dashboard');
                exit;
            } else {
                $_SESSION['error'] = "El correo o la contraseña son incorrectos.";
                header('Location: index.php?view=login');
                exit;
            }
        }

        public function handleLogout(): void {
            AuthService::logout();
            header('Location: index.php?view=login');
            exit;
        }
    }
?>