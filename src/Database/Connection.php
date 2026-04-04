<?php

    namespace App\Database;
    use PDO;
    use PDOException;

    class Connection {
        private static ?PDO $instance = null;

        public static function getInstance(): PDO {
            if (self::$instance === null) {
                $config = require __DIR__ . '/../../config/database.php';
                $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";

                try {
                    self::$instance = new PDO($dsn, $config['user'], $config['pass'], [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]);
                } catch (PDOException $e) {
                    die("Error de conexión: " . $e->getMessage());
                }
            }
            return self::$instance;
        }
    }

?>