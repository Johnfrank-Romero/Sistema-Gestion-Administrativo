<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="login-container">
    <h2><i class="fa-solid fa-lock-open"></i> Actualizar Contraseña</h2>
    <p>Por seguridad, debes cambiar tu clave temporal para continuar.</p>

    <form action="<?= BASE_URL ?>update-password" method="POST">
        <div class="form-group">
            <label>Nueva Contraseña</label>
            <input type="password" name="new_password" required placeholder="********">
            <small>Mínimo 8 caracteres, letras y números.</small>
        </div>
        
        <div class="form-group">
            <label>Confirmar Contraseña</label>
            <input type="password" name="confirm_password" required placeholder="********">
        </div>

        <button type="submit" class="btn-login">Actualizar y Entrar</button>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>