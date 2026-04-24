<div class="admin-form-container border-0 shadow-sm">
    <div class="text-center mb-4">
        <i class="fa-solid fa-user-plus fa-3x text-primary mb-3"></i>
        <h2 class="fw-bold">Registrar Nuevo Administrador</h2>
        <p class="text-muted">Completa los datos para crear una nueva cuenta de acceso.</p>
    </div>

    <form action="<?= BASE_URL ?>users/store" method="POST" class="needs-validation">
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">
                    <i class="fa-solid fa-address-card me-1"></i> Primer Nombre
                </label>
                <input type="text" name="firstName" class="form-control" required placeholder="Ej. Alejandro">
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">
                    <i class="fa-solid fa-address-card me-1"></i> Primer Apellido
                </label>
                <input type="text" name="lastName" class="form-control" required placeholder="Ej. Medina">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">
                <i class="fa-solid fa-envelope me-1"></i> Correo Electrónico
            </label>
            <input type="email" name="email" class="form-control" required placeholder="admin@hotmail.com">
        </div>
        
        <div class="mb-4">
            <label class="form-label fw-semibold">
                <i class="fa-solid fa-shield-halved me-1"></i> Rol de Usuario
            </label>
            <select name="role" class="form-select">
                <option value="admin">Administrador Regular</option>
                <option value="super_admin">Super Administrador</option>
            </select>
        </div>

        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="fa-solid fa-circle-info fa-lg me-3"></i>
            <div>
                <strong>Nota del Sistema:</strong> 
                La clave temporal será generada automáticamente y se mostrará al finalizar el registro.
            </div>
        </div>

        <button type="submit" class="btn-submit-admin w-100 py-3 shadow-sm">
            <i class="fa-solid fa-user-check me-2"></i> Registrar y Generar Clave
        </button>
    </form>
</div>