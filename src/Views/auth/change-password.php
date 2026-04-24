<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container d-flex flex-grow-1 align-items-center justify-content-center py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
            
            <div class="login-container shadow-lg border-0">
                <div class="text-center mb-4">
                    <div class="icon-badge bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-lock-open fa-2x"></i>
                    </div>
                    <h2 class="fw-bold">Actualizar Clave</h2>
                    <p class="text-muted small">Por seguridad, debes cambiar tu clave temporal para continuar.</p>
                </div>

                <form action="<?= BASE_URL ?>update-password" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nueva Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-key text-muted"></i></span>
                            <input type="password" name="new_password" class="form-control border-start-0" required placeholder="Mínimo 8 caracteres">
                        </div>
                        <div class="form-text mt-2 p-2 bg-light rounded border-start border-primary border-3">
                            <i class="fa-solid fa-circle-info me-1"></i> Debe contener letras, números y caracteres especiales.
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-check-double text-muted"></i></span>
                            <input type="password" name="confirm_password" class="form-control border-start-0" required placeholder="Repite tu contraseña">
                        </div>
                    </div>

                    <button type="submit" class="btn-login w-100 py-3 shadow-sm">
                        <i class="fa-solid fa-shield-check me-2"></i> Actualizar y Entrar
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>