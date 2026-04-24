        </div> 
        <footer class="main-footer bg-dark text-white-50 py-4">
            <div class="container">
                <div class="row align-items-center">
                    
                    <div class="col-lg-4 text-center text-lg-start mb-3 mb-lg-0">
                        <h6 class="text-uppercase fw-bold text-white mb-1">
                            <i class="fa-solid fa-building-shield me-2"></i>Asociación Civil La Floresta
                        </h6>
                        <p class="small mb-0">Gestión administrativo integral.</p>
                    </div>

                    <div class="col-lg-4 text-center mb-3 mb-lg-0">
                        <div class="d-flex justify-content-center gap-3 small">
                            <span><i class="fas fa-code-branch me-1"></i> v2.0</span>
                            <span><i class="fas fa-calendar-alt me-1"></i> <?= date('d/m/Y') ?></span>
                        </div>
                    </div>

                    <div class="col-lg-4 text-center text-lg-end">
                        <div class="d-inline-flex gap-3">
                            <a href="<?= BASE_URL ?>dashboard" class="text-white-50 text-decoration-none small hover-link">Panel</a>
                            <a href="<?= BASE_URL ?>logout" class="text-danger text-decoration-none small hover-link" onclick="return confirm('¿Deseas cerrar la sesión?')">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>

                <hr class="my-3 opacity-10">

                <div class="text-center">
                    <p class="small mb-0" style="font-size: 0.75rem;">
                        &copy; <?= date('Y') ?> Asociación Civil de Propietarios y Residentes Parques Comercio Industrial La Floresta.
                    </p>
                </div>
            </div>
        </footer>

        <script src="<?= BASE_URL ?>bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= BASE_URL ?>javascript/alerts.js"></script>
    </body>
</html>