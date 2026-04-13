<?php

    namespace App\Services;
    use App\DAO\UserDAO;
    use App\Models\User;

    class AuthService {
        private UserDAO $userDao;

        public function __construct(UserDAO $userDao) {
            $this->userDao = $userDao;
        }

        public function login(string $email, string $password): ?User {
            $user = $this->userDao->findByEmail($email);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) session_start();

                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_name'] = $user->firstName;
                $_SESSION['user_role'] = $user->role;
                $_SESSION['must_change_password'] = (bool)$user->isTemporaryPassword;

                session_write_close();
                return $user;
            }
            return null;
        }

        public static function logout(): void {
            if (session_status() === PHP_SESSION_NONE) session_start();
            session_destroy();
        }

        public static function isLoggedIn(): bool {
            if (session_status() === PHP_SESSION_NONE) session_start();
            return isset($_SESSION['user_id']);
        }

        //Verificar si es super admin//
        public static function isSuperAdmin(): bool {
            return ($_SESSION['user_role'] ?? '') === User::ROLE_SUPER_ADMIN;
        }
    }
?>