<?php

    namespace App\DAO;
    use App\Models\User;
    use PDO;

    class UserDAO {
        private PDO $db;

        public function __construct(PDO $db) {
            $this->db = $db;
        }

        //Obtener usuarios activos//
        public function getAllActive(): array {
            $sql = "SELECT * FROM users WHERE deleted_at IS NULL ORDER BY created_at DESC";
            $stmt = $this->db->query($sql);
            $users = [];

            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User(
                    id: (int)$data['id'],
                    email: $data['email'],
                    password: $data['password'],
                    firstName: $data['first_name'],
                    lastName: $data['last_name'],
                    role: $data['role'],
                    isTemporaryPassword: (bool)$data['is_temporary_password'],
                    createdAt: $data['created_at'],
                    deletedAt: $data['deleted_at'],
                    isNew: false
                );
            }
            return $users;
        }

        public function getAllInactive(): array {
            $sql = "SELECT * FROM users WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC";
            $stmt = $this->db->query($sql);
            $users = [];

            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User(
                    id: (int)$data['id'],
                    email: $data['email'],
                    password: $data['password'],
                    firstName: $data['first_name'],
                    lastName: $data['last_name'],
                    role: $data['role'],
                    isTemporaryPassword: (bool)$data['is_temporary_password'],
                    createdAt: $data['created_at'],
                    deletedAt: $data['deleted_at'],
                    isNew: false
                );
            }
            return $users;
        }

        public function softDelete(int $id): bool {
            $sql = "UPDATE users SET deleted_at = NOW() WHERE id = :id";
            return $this->db->prepare($sql)->execute([':id' => $id]);
        }

        public function restore(int $id): bool {
            $sql = "UPDATE users SET deleted_at = NULL WHERE id = :id";
            return $this->db->prepare($sql)->execute([':id' => $id]);
        }

        public function updateToTemporaryPassword(int $id, string $hashedPassword): bool {
            $sql = "UPDATE users SET 
                    password = :password, 
                    is_temporary_password = 1 
                    WHERE id = :id";
            
            return $this->db->prepare($sql)->execute([
                ':password' => $hashedPassword,
                ':id'       => $id
            ]);
        }

        public function create(User $user): bool {
            $sql = "INSERT INTO users (email, password, first_name, last_name, role, is_temporary_password) 
                    VALUES (:email, :password, :firstName, :lastName, :role, :isTemp)";
            
            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':email'     => $user->email,
                ':password'  => $user->password, 
                ':firstName' => $user->firstName,
                ':lastName'  => $user->lastName,
                ':role'      => $user->role,
                ':isTemp'    => $user->isTemporaryPassword ? 1 : 0
            ]);
        }

        public function findByEmail(string $email): ?User {
            $sql = "SELECT * FROM users WHERE email = :email AND deleted_at IS NULL LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) return null;

            //Retornar instancia del Modelo con los datos de la DB//
            return new User(
                id: (int)$data['id'],
                email: $data['email'],
                password: $data['password'], 
                firstName: $data['first_name'],
                lastName: $data['last_name'],
                role: $data['role'],
                isTemporaryPassword: (bool)$data['is_temporary_password'],
                createdAt: $data['created_at'],
                deletedAt: $data['deleted_at'],
                isNew: false
            );
        }

        public function updatePassword(int $userId, string $hashedPassword): bool {
            $sql = "UPDATE users 
                    SET password = :password, 
                        is_temporary_password = 0 
                    WHERE id = :id";
            
            try {
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([
                    ':password' => $hashedPassword,
                    ':id'       => $userId
                ]);
            } catch (\PDOException $e) {
                // En desarrollo, esto te ayudará a ver si algo falla con la DB
                error_log("Error en UserDAO::updatePassword: " . $e->getMessage());
                return false;
            }
        }
    }
?>