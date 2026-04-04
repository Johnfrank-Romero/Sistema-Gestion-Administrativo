<?php

    use PHPUnit\Framework\TestCase;
    use App\Models\User;

    class UserTest extends TestCase {

        public function testCumulativeValidations() {
            //Intentar crear un usuario con todos los datos erroneos//
            try {
                new User(
                    email: 'error-email',      
                    password: '123',           
                    firstName: 'John 123',     
                    lastName: 'Doe 456'       
                );
                $this->fail("Se esperaba una InvalidArgumentException pero no se lanzó.");
            } catch (\InvalidArgumentException $e) {
                //Verifica que el mensaje sea un JSON valido//
                $errors = json_decode($e->getMessage(), true);
                $this->assertIsArray($errors, "La excepción debe contener un JSON de errores.");

                //Verifica que contenga los errores especificos//
                $this->assertContains("El nombre solo debe contener letras sin espacios.", $errors);
                $this->assertContains("El formato del email es inválido.", $errors);
                $this->assertContains("La contraseña es muy débil o no cumple los requisitos de seguridad.", $errors);
            }
        }

        public function testSuccessfulCreationAndHashing() {
            //Un usuario valido//
            $user = new User(
                email: 'admin@gmail.com',
                password: 'Password123!',
                firstName: 'John',
                lastName: 'Doe'
            );

            //Verifica que los datos se asignen y se limpien//
            $this->assertEquals('John', $user->firstName);
            $this->assertEquals('admin@gmail.com', $user->email);
            
            //Verifica que la contraseña no sea texto plano (debe estar hasheada)//
            $this->assertNotEquals('Password123!', $user->password);
            $this->assertTrue(password_verify('Password123!', $user->password));
        }

        public function testDatabaseLoadDoesNotValidate() {
            //Simular carga desde la DB (isNew = false)//
            $hashFromDb = '$2y$10$SomethingGenericHash';
            
            $user = new User(
                email: 'viejo@correo.ru', //Dominio no permitido en registro//
                password: $hashFromDb,    //No cumple regex de seguridad//
                firstName: 'John',
                lastName: 'Doe',
                isNew: false              //El truco esta aqui//
            );

            $this->assertEquals($hashFromDb, $user->password);
            $this->assertEquals('viejo@correo.ru', $user->email);
        }
    }
?>