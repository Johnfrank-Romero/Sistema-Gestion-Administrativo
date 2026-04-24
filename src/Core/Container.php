<?php

    namespace App\Core;
    use App\DAO\UserDAO;
    use App\DAO\OwnerDAO;
    use App\Services\AuthService;
    use App\Services\CurrencyService;
    use App\Controllers\AuthController;
    use App\Controllers\UserController;
    use App\Controllers\OwnerController;
    use App\Database\Connection; 
    use PDO;
    use Exception;

    class Container {
        private static ?PDO $db = null;

        private static function getDb(): PDO {
            if (self::$db === null) {
                try {
                    self::$db = Connection::getInstance();
                } catch (Exception $e) {
                    die("Error crítico: No se pudo conectar a la DB. " . $e->getMessage());
                }
            }
            return self::$db;
        }

        public static function getAuthController(): AuthController {
            $db = self::getDb();
            $userDao = new UserDAO($db);
            $authService = new AuthService($userDao);
            
            return new AuthController($authService, $userDao);
        }

        public static function getUserController(): UserController {
            return new UserController(new UserDAO(self::getDb()));
        }

        public static function getCurrencyService(): CurrencyService {
            return new CurrencyService(self::getDb());
        }

        public static function getOwnerController(): OwnerController {
            return new OwnerController(new OwnerDAO(self::getDb()));
        }
    }
?>