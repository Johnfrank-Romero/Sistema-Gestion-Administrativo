<?php
    
    if (session_status() === PHP_SESSION_NONE) session_start();
    //El login solo recibe un string de error//
    $error = $_SESSION['error'] ?? null;
    $success = $_SESSION['success'] ?? null;
    unset($_SESSION['error'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Login - Gestión Administrativo</title>
        <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
    </head>
    <body>
        <?php if ($error): ?>
            <div class="floating-alert error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="floating-alert success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <div class="login-container">
            <h2>Iniciar Sesión</h2>

            <form action="index.php?action=login" method="POST">
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="email" required placeholder="admin@gmail.com">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" required placeholder="********">
                </div>
                <button type="submit" class="btn-login">Acceder</button>
            </form>

            <div class="auth-footer">
                <p>¿No tienes cuenta? <a href="<?= BASE_URL ?>registro">Regístrate aquí</a></p>
            </div>
        </div>
        <script src="<?= BASE_URL ?>javascript/alerts.js"></script>
    </body>
</html>