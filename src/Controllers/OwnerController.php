<?php

    namespace App\Controllers;
    use App\DAO\OwnerDAO;
    use App\Models\Owner;
    use App\Services\AuthService;
    use InvalidArgumentException;

    class OwnerController {
        private $ownerDao;

        public function __construct(OwnerDAO $ownerDao) {
            $this->ownerDao = $ownerDao;
        }

        //Mostrar lista de propietarios//
        public function index() {
            $owners = $this->ownerDao->getAll();
            $viewPath = __DIR__ . "/../Views/";
            $content = $viewPath . 'owners/index.php';
            include $viewPath . 'dashboard.php';
        }

        //Procesar registro de nuevo propietario//
        public function store() {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

            try {
            //Crear instancia del modelo//
            $owner = new Owner(
                rif: $_POST['rif'] ?? '',
                name: $_POST['name'] ?? '',
                phone: $_POST['phone'] ?? null,
                email: $_POST['email'] ?? null
            );

            //Verificar si el RIF ya existe//
            if ($this->ownerDao->getByRif($owner->rif)) {
                throw new InvalidArgumentException(json_encode(["Ya existe un propietario registrado con ese RIF."], JSON_UNESCAPED_UNICODE));
            }

            if ($this->ownerDao->create($owner)) {
                $_SESSION['success'] = "Propietario registrado exitosamente.";
                header('Location: ' . BASE_URL . 'owners');
            } else {
                $_SESSION['error'] = "Error interno al procesar el registro.";
                header('Location: ' . BASE_URL . 'owners/create');
            }

        } catch (InvalidArgumentException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . BASE_URL . 'owners/create');
        }
        exit;
        }

        public function edit(int $id) {
            $owner = $this->ownerDao->getById($id);
            if (!$owner) {
                $_SESSION['error'] = "Propietario no encontrado.";
                header('Location: ' . BASE_URL . 'owners');
                exit;
            }

            $viewPath = __DIR__ . "/../Views/";
            //Reutilizar el layout del dashboard pasando la vista de edicion//
            $content = $viewPath . 'owners/edit.php'; 
            include $viewPath . 'dashboard.php';
        }

        public function update(int $id) {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

            try {
                $owner = new Owner(
                    id: $id,
                    rif: $_POST['rif'] ?? '',
                    name: $_POST['name'] ?? '',
                    phone: $_POST['phone'] ?? null,
                    email: $_POST['email'] ?? null,
                    isNew: false //Importante para que el modelo reconozca que es actualizacion//
                );

                if ($this->ownerDao->update($owner)) {
                    $_SESSION['success'] = "Datos del propietario actualizados.";
                    header('Location: ' . BASE_URL . 'owners');
                } else {
                    throw new \Exception("No se pudo actualizar en la base de datos.");
                }
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: ' . BASE_URL . "owners/edit/$id");
            }
            exit;
        }

        public function delete(int $id) {
            //Solo Super_Admin puede hacerlo//
            if (!AuthService::isSuperAdmin()) {
                $_SESSION['error'] = "No tienes permisos para realizar esta acción.";
                header('Location: ' . BASE_URL . 'owners');
                exit;
            }

            if ($this->ownerDao->delete($id)) {
                $_SESSION['success'] = "Propietario eliminado correctamente.";
            } else {
                $_SESSION['error'] = "No se pudo eliminar el registro.";
            }
            header('Location: ' . BASE_URL . 'owners');
            exit;
        }
    }
?>