<?php

    namespace App\DAO;
    use App\Models\User;
    use PDO;

    class UserDAO {
        private PDO $db;

        public function __construct(PDO $db) {
            $this->db = $db;
        }

        public function create(User $user): bool {
            $sql = "INSERT INTO users (email, password, first_name, last_name) 
                    VALUES (:email, :password, :firstName, :lastName)";
            
            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                ':email'     => $user->email,
                ':password'  => $user->password, 
                ':firstName' => $user->firstName,
                ':lastName'  => $user->lastName
            ]);
        }

        public function findByEmail(string $email): ?User {
            $sql = "SELECT id, email, password, first_name, last_name FROM users WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return null;
            }

            //Retornar instancia del Modelo con los datos de la DB//
            return new User(
                id: (int)$data['id'],
                email: $data['email'],
                password: $data['password'], 
                firstName: $data['first_name'],
                lastName: $data['last_name'],
                isNew: false
            );
        }
    }
?>