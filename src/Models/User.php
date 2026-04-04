<?php

    namespace App\Models;
    use InvalidArgumentException;

    class User {
        public function __construct(
            public ?int $id = null,
            public string $email = '',
            public string $password = '',
            public string $firstName = '',
            public string $lastName = '',
            bool $isNew = true
        ) {
            if ($isNew) {
                $errors = [];

                //Sanitizacion//
                $firstName = mb_convert_case(trim($firstName), MB_CASE_TITLE, "UTF-8");
                $lastName = mb_convert_case(trim($lastName), MB_CASE_TITLE, "UTF-8");
                $email = strtolower(trim($email));

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

                $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])\S{8,64}$/';
                if (!preg_match($pattern, $password)) {
                    $errors[] = "La contraseña es muy débil o no cumple los requisitos de seguridad.";
                }

                //Si hay errores, se crea el formato JSON)//
                if (!empty($errors)) {
                    if (!empty($errors)) {
                        //El flag JSON_UNESCAPED_UNICODE evita el \u00e1//
                        throw new \InvalidArgumentException(json_encode($errors, JSON_UNESCAPED_UNICODE));
                    }
                }

                $password = password_hash($password, PASSWORD_BCRYPT);
            }

            //Asignacion//
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
            $this->password = $password;
        }
    }
?>