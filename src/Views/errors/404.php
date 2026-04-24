<div class="container d-flex flex-column align-items-center justify-content-center min-vh-100 text-center">
    <div class="error-wrapper p-5">
        <h1 class="display-1 fw-bold text-danger mb-0" style="text-shadow: 4px 4px 10px rgba(0,0,0,0.1);">404</h1>
        
        <div class="card border-0 shadow-lg mt-n4 position-relative" style="z-index: 2; border-radius: 20px;">
            <div class="card-body p-5">
                <i class="fa-solid fa-compass-drafting fa-4x text-danger mb-4"></i>
                <h2 class="fw-bold text-dark">¡Ups! Te has perdido</h2>
                <p class="text-muted mb-4">
                    La página que buscas no existe o ha sido movida temporalmente.<br>
                    Verifica la dirección o utiliza el botón inferior.
                </p>
                
                <a href="<?= BASE_URL ?>dashboard" class="btn btn-primary btn-lg px-5 shadow-sm rounded-pill">
                    <i class="fa-solid fa-house me-2"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</div>