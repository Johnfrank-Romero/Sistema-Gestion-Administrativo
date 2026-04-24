<?php

    namespace App\Models;
    use InvalidArgumentException;

    class Owner {
        public function __construct(
            public ?int $id = null,
            public string $rif = '',
            public string $name = '',
            public ?string $phone = null,
            public ?string $email = null,
            bool $isNew = true
        ) {
            if ($isNew) {
                $errors = [];

                //Sanitizacion//
                $this->rif = strtoupper(trim($rif));
                $this->name = mb_convert_case(trim($name), MB_CASE_UPPER, "UTF-8");
                $this->email = !empty($email) ? strtolower(trim($email)) : null;

                //Validacion de RIF//
                if (!preg_match('/^[VJGPEvtjge][-][0-9]+$/', $this->rif)) {
                    $errors[] = "El RIF debe tener un formato válido (Ej: J-12345678).";
                }

                //Validacion de Nombre/Razon Social//
                if (strlen($this->name) < 3) {
                    $errors[] = "El nombre o razón social es demasiado corto.";
                }

                //Validacion de Telefono (Formato: 0414-7580824)//
                if (!empty($phone)) {
                    if (!preg_match('/^0(412|414|424|416|426|212|241|243|245)[-]\d{7}$/', $phone)) {
                        $errors[] = "El teléfono debe tener el formato 0414-1234567.";
                    }
                    $this->phone = $phone;
                }

                //Validacion de Email (cualquier dominio)//
                if ($this->email && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "El correo electrónico no tiene un formato válido.";
                }

                if (!empty($errors)) {
                    throw new InvalidArgumentException(json_encode($errors, JSON_UNESCAPED_UNICODE));
                }
            }
        }
    }
?>