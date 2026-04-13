<?php

    namespace App\Models;
    use InvalidArgumentException;

    class User {
        // Constantes para roles//
        const ROLE_SUPER_ADMIN = 'super_admin';
        const ROLE_ADMIN = 'admin';

        public function __construct(
            public ?int $id = null,
            public string $email = '',
            public string $password = '',
            public string $firstName = '',
            public string $lastName = '',
            public string $role = self::ROLE_ADMIN,
            public bool $isTemporaryPassword = false,
            public ?string $createdAt = null,
            public ?string $deletedAt = null,
            bool $isNew = true
        ) {
            if ($isNew) {
                $errors = [];

                //Sanitizacion//
                $this->firstName = mb_convert_case(trim($firstName), MB_CASE_TITLE, "UTF-8");
                $this->lastName = mb_convert_case(trim($lastName), MB_CASE_TITLE, "UTF-8");
                $this->email = strtolower(trim($email));

                //Validaciones//
                if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $firstName)) {
                    $errors[] = "El nombre solo debe contener letras sin espacios.";
                }

                if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $lastName)) {
                    $errors[] = "El apellido solo debe contener letras sin espacios.";
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "El formato del email es inválido.";
                } else {
                    $allowedDomains = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com'];
                    $domain = explode('@', $email)[1] ?? '';
                    if (!in_array($domain, $allowedDomains)) {
                        $errors[] = "El dominio del correo no está permitido.";
                    }
                }

                try {
                    self::validatePasswordSecurity($password);
                } catch (InvalidArgumentException $e) {
                    //Decodificar JSON//
                    $passErrors = json_decode($e->getMessage(), true);
                    $errors = array_merge($errors, $passErrors);
                }

                if (!in_array($role, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN])) {
                    $errors[] = "El rol asignado no es válido.";
                }

                if (!empty($errors)) {
                    throw new InvalidArgumentException(json_encode($errors, JSON_UNESCAPED_UNICODE));
                }

                $this->password = password_hash($password, PASSWORD_BCRYPT);
                $this->role = $role;
                $this->isTemporaryPassword = $isTemporaryPassword;
            }
        }

        public static function validatePasswordSecurity(string $password): void {
            $errors = [];
            if (strlen($password) < 8) {
                $errors[] = "La contraseña debe tener al menos 8 caracteres.";
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $errors[] = "Debe incluir al menos una letra mayúscula.";
            }
            if (!preg_match('/[a-z]/', $password)) {
                $errors[] = "Debe incluir al menos una letra minúscula.";
            }
            if (!preg_match('/\d/', $password)) {
                $errors[] = "Debe incluir al menos un número.";
            }
            if (!preg_match('/[\W_]/', $password)) {
                $errors[] = "Debe incluir al menos un carácter especial (ej: !@#$%).";
            }

            if (!empty($errors)) {
                throw new InvalidArgumentException(json_encode($errors, JSON_UNESCAPED_UNICODE));
            }
        }

        public function isSuperAdmin(): bool {
            return $this->role === self::ROLE_SUPER_ADMIN;
        }
    }
?>