<?php

    namespace App\Services;
    use App\DAO\UserDAO;
    use App\Models\User;

    class AuthService {
        private UserDAO $userDao;

        public function __construct(UserDAO $userDao) {
            $this->userDao = $userDao;
        }

        public function register(\App\Models\User $user): bool {
            return $this->userDao->create($user);
        }

        public function login(string $email, string $password): ?User {
            $user = $this->userDao->findByEmail($email);

            if (!$user) {
                return null; 
            }

            if (password_verify($password, $user->password)) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                //Guardar datos basicos en la sesion//
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_name'] = $user->firstName;

                return $user;
            }
            return null; 
        }

        public static function logout(): void {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_destroy();
        }

        public static function isLoggedIn(): bool {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            return isset($_SESSION['user_id']);
        }
    }
?>