<?php

    namespace App\DAO;
    use App\Models\Owner;
    use PDO;

    class OwnerDAO {
        private $db;

        public function __construct(PDO $db) {
            $this->db = $db;
        }

        //Registrar nuevo propietario//
        public function create(Owner $owner): bool {
            $sql = "INSERT INTO owners (rif, name, phone, email) VALUES (:rif, :name, :phone, :email)";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                ':rif'   => $owner->rif,
                ':name'  => $owner->name,
                ':phone' => $owner->phone,
                ':email' => $owner->email
            ]);
        }

        public function getAll(): array {
            $sql = "SELECT * FROM owners ORDER BY name ASC";
            $stmt = $this->db->query($sql);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return array_map(fn($data) => new Owner(
                id: (int)$data['id'],
                rif: $data['rif'],
                name: $data['name'],
                phone: $data['phone'],
                email: $data['email'],
                isNew: false
            ), $results);
        }

        public function getByRif(string $rif): ?Owner {
            $sql = "SELECT * FROM owners WHERE rif = :rif LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':rif' => strtoupper(trim($rif))]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $data ? new Owner(
                id: (int)$data['id'],
                rif: $data['rif'],
                name: $data['name'],
                phone: $data['phone'],
                email: $data['email'],
                isNew: false
            ) : null;
        }

        public function getById(int $id): ?Owner {
            $sql = "SELECT * FROM owners WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $data ? new Owner(
                id: (int)$data['id'],
                rif: $data['rif'],
                name: $data['name'],
                phone: $data['phone'],
                email: $data['email'],
                isNew: false
            ) : null;
        }

        public function update(Owner $owner): bool {
            $sql = "UPDATE owners SET 
                    rif = :rif, 
                    name = :name, 
                    phone = :phone, 
                    email = :email 
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                ':id'    => $owner->id,
                ':rif'   => $owner->rif,
                ':name'  => $owner->name,
                ':phone' => $owner->phone,
                ':email' => $owner->email
            ]);
        }

        public function delete(int $id): bool {
            $sql = "DELETE FROM owners WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        }
    }
?>