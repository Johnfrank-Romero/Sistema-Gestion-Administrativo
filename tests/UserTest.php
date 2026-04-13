<?php

    use PHPUnit\Framework\TestCase;
    use App\Models\User;

    class UserTest extends TestCase {

        //Capturar validaciones//
        public function testCumulativeValidations() {
            try {
                new User(
                    email: 'error-email',      
                    password: '123',           
                    firstName: 'John 123',     
                    lastName: 'Doe 456',
                    role: 'invalid_role'
                );
                $this->fail("Se esperaba una InvalidArgumentException pero no se lanzó.");
            } catch (\InvalidArgumentException $e) {
                $errors = json_decode($e->getMessage(), true);
                $this->assertIsArray($errors);

                $this->assertContains("El nombre solo debe contener letras sin espacios.", $errors);
                $this->assertContains("El formato del email es inválido.", $errors);
                $this->assertContains("La contraseña es muy débil o no cumple los requisitos de seguridad.", $errors);
                $this->assertContains("El rol asignado no es válido.", $errors);
            }
        }

        //Verificar creacion exitosa con roles y contraseña temporal//
        public function testSuccessfulCreationWithRoleAndTempFlag() {
            $user = new User(
                email: 'admin@gmail.com',
                password: 'Password123!',
                firstName: 'John',
                lastName: 'Doe',
                role: User::ROLE_SUPER_ADMIN,
                isTemporaryPassword: true
            );

            $this->assertEquals('John', $user->firstName);
            $this->assertEquals(User::ROLE_SUPER_ADMIN, $user->role);
            $this->assertTrue($user->isTemporaryPassword);
            $this->assertTrue($user->isSuperAdmin());
            
            //El hash debe funcionar correctamente//
            $this->assertTrue(password_verify('Password123!', $user->password));
        }

        //Verificar carga de datos de la DB sin valiaciones//
        public function testDatabaseLoadPreservesAllFields() {
            $hashFromDb = '$2y$10$SomethingGenericHash';
            $createdAt = '2026-04-12 15:00:00';
            
            $user = new User(
                id: 1,
                email: 'antiguo@no-permitido.com', 
                password: $hashFromDb,
                firstName: 'Admin',
                lastName: 'User',
                role: User::ROLE_ADMIN,
                isTemporaryPassword: false,
                createdAt: $createdAt,
                deletedAt: null,
                isNew: false
            );

            $this->assertEquals(1, $user->id);
            $this->assertEquals($hashFromDb, $user->password);
            $this->assertEquals(User::ROLE_ADMIN, $user->role);
            $this->assertEquals($createdAt, $user->createdAt);
            $this->assertFalse($user->isTemporaryPassword);
            $this->assertNull($user->deletedAt);
        }

        //Prueba de soft delete en el modelo//
        public function testModelHandlesSoftDeleteField() {
            $deletedTime = '2026-04-12 15:30:00';
            $user = new User(
                email: 'deleted@gmail.com',
                password: 'HashFromDatabase123',
                firstName: 'Old',
                lastName: 'User',
                deletedAt: $deletedTime,
                isNew: false
            );

            $this->assertEquals($deletedTime, $user->deletedAt);
        }
    }
?>