<?php

    if (session_status() === PHP_SESSION_NONE) session_start();
    $errors = $_SESSION['errors'] ?? [];
    $success = $_SESSION['success'] ?? null;
    unset($_SESSION['errors'], $_SESSION['success']); 
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registro - Gestión Administrativo</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php if (!empty($errors)): ?>
            <div class="floating-alert error">
                <strong>Corrige lo siguiente:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="floating-alert success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <div class="login-container">
            <h2>Crear Cuenta Admin</h2>

            <form action="index.php?action=register" method="POST">
                <div class="form-group">
                    <label>Primer Nombre</label>
                    <input type="text" name="firstName" required placeholder="Alejandro">
                </div>
                <div class="form-group">
                    <label>Primer Apellido</label>
                    <input type="text" name="lastName" required placeholder="Medina">
                </div>
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" required placeholder="admin@hotmail.com">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" required placeholder="********">
                    <h6>Debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.</h6>
                </div>
                <button type="submit" class="btn-login">Registrar</button>
            </form>

            <div class="auth-footer">
                ¿Ya tienes cuenta? <a href="index.php?view=login">Inicia sesión aquí</a>
            </div>
        </div>
        <script src="javascript/alerts.js"></script>
    </body>
</html>