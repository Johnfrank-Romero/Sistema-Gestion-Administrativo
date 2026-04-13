<div class="admin-form-container">
    <h2><i class="fa-solid fa-user-plus"></i> Registrar Nuevo Administrador</h2>

    <form action="<?= BASE_URL ?>users/store" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label><i class="fa-solid fa-address-card"></i> Primer Nombre</label>
                <input type="text" name="firstName" required placeholder="Ej. Alejandro">
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-address-card"></i> Primer Apellido</label>
                <input type="text" name="lastName" required placeholder="Ej. Medina">
            </div>
        </div>

        <div class="form-group">
            <label><i class="fa-solid fa-envelope"></i> Correo Electrónico</label>
            <input type="email" name="email" required placeholder="admin@hotmail.com">
        </div>
        
        <div class="form-group">
            <label><i class="fa-solid fa-shield-halved"></i> Rol de Usuario</label>
            <select name="role" class="form-control" style="width: 100%; padding: 0.8rem; border-radius: 4px; border: 1px solid #ddd;">
                <option value="admin">Administrador Regular</option>
                <option value="super_admin">Super Administrador</option>
            </select>
        </div>

        <div class="form-group" style="background: #f8f9fa; padding: 1rem; border-radius: 6px; border-left: 4px solid #3498db;">
            <p style="margin: 0; font-size: 0.9rem; color: #34495e;">
                <i class="fa-solid fa-robot"></i> <strong>Nota del Sistema:</strong> 
                La contraseña será generada automáticamente y se mostrará al finalizar el registro.
            </p>
        </div>

        <button type="submit" class="btn-submit-admin">
            <i class="fa-solid fa-user-check"></i> Registrar y Generar Clave
        </button>
    </form>
</div>