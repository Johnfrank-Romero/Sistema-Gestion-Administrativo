<?php

    include __DIR__ . '/layouts/header.php'; 
?>

<div class="login-container">
    <h2>Iniciar Sesión</h2>

    <form action="<?= BASE_URL ?>login" method="POST">
        <div class="form-group">
            <label>Correo Electrónico</label>
            <input type="email" name="email" required placeholder="admin@dominio.com">
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required placeholder="********">
        </div>
        <button type="submit" class="btn-login">Acceder</button>
    </form>
</div>

<?php 
    include __DIR__ . '/layouts/footer.php'; 
?>