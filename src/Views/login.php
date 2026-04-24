<?php
    include __DIR__ . '/layouts/header.php'; 
?>

<div class="container d-flex flex-grow-1 align-items-center justify-content-center py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
            
            <div class="login-container">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-shield-halved fa-3x text-primary mb-3"></i>
                    <h2 class="fw-bold">Iniciar Sesión</h2>
                    <p class="text-muted small">Ingresa tus credenciales para acceder al sistema</p>
                </div>

                <form action="<?= BASE_URL ?>login" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-envelope me-1"></i> Correo Electrónico
                        </label>
                        <input type="email" 
                                name="email" 
                                class="form-control form-control-lg" 
                                required 
                                placeholder="admin@dominio.com">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-lock me-1"></i> Contraseña
                        </label>
                        <input type="password" 
                                name="password" 
                                class="form-control form-control-lg" 
                                required 
                                placeholder="********">
                    </div>

                    <button type="submit" class="btn-login w-100 shadow-sm">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Acceder
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<?php 
    include __DIR__ . '/layouts/footer.php'; 
?>