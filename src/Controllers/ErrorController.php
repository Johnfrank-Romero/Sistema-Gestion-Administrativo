<?php

    namespace App\Controllers;

    class ErrorController {
        public function notFound(): void {
            http_response_code(404);
            $title = "404 - Página no encontrada";
            
            //Cargar la vista dentro del layout general para mantener el diseño//
            include __DIR__ . '/../Views/layouts/header.php';
            include __DIR__ . '/../Views/errors/404.php';
            include __DIR__ . '/../Views/layouts/footer.php';
        }
    }
?>