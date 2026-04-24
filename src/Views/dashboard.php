<?php
    include __DIR__ . '/layouts/header.php'; 

    //Obtener ruta//
    $current_route = str_replace(BASE_URL, '', $_SERVER['REQUEST_URI']);
    $current_route = explode('?', $current_route)[0];
    $current_route = trim($current_route, '/');

    use App\Core\Container;

    $currencyService = Container::getCurrencyService();
    $storedRate = $currencyService->getTodayStoredRate();
    $bcvRate = null;

    if (!$storedRate) {
        $bcvRate = $currencyService->fetchBcvRate();
    }
?>

<div class="dashboard-container">
    <aside class="sidebar d-none d-lg-flex flex-column">
        <div class="p-3">
            <h3 class="fs-6 fw-bold text-uppercase opacity-75 text-white">
                <i class="fa-solid fa-building-shield me-2"></i>Gestión
            </h3>
        </div>
        
        <nav class="flex-grow-1">
            <a href="<?= BASE_URL ?>dashboard" class="nav-link text-white p-3 <?= $current_route === 'dashboard' ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-line me-2"></i> Inicio
            </a>
            <!--- Opciones para Super_Admin --->
            <?php if ($_SESSION['user_role'] === 'super_admin'): ?>
                <a class="nav-link text-white p-3 d-flex justify-content-between align-items-center" 
                    data-bs-toggle="collapse" 
                    href="#menuUsuarios" 
                    role="button" 
                    aria-expanded="<?= in_array($current_route, ['users', 'users/create', 'users/inactive']) ? 'true' : 'false' ?>">
                    <span><i class="fa-solid fa-users-gear me-2"></i> USUARIOS</span>
                </a>
                
                <div class="collapse <?= in_array($current_route, ['users', 'users/create', 'users/inactive']) ? 'show' : '' ?>" id="menuUsuarios">
                    <div class="d-flex flex-column">
                        <div class="bg-dark bg-opacity-25">
                            <a href="<?= BASE_URL ?>users" class="nav-link submenu-item text-white-50 p-2 <?= $current_route === 'users' ? 'active text-white' : '' ?>">
                                <i class="fa-solid fa-list-check me-2"></i> Listar Activos
                            </a>
                            <a href="<?= BASE_URL ?>users/create" class="nav-link submenu-item text-white-50 p-2 <?= $current_route === 'users/create' ? 'active text-white' : '' ?>">
                                <i class="fa-solid fa-user-plus me-2"></i> Registrar Nuevo
                            </a>
                            <a href="<?= BASE_URL ?>users/inactive" class="nav-link submenu-item text-white-50 p-2 <?= $current_route === 'users/inactive' ? 'active text-white' : '' ?>">
                                <i class="fa-solid fa-user-slash me-2"></i> Inactivos
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!--- Opciones comunes para Super_Admin y Admin --->
            <a class="nav-link text-white p-3 d-flex justify-content-between align-items-center" 
                    data-bs-toggle="collapse" 
                    href="#menuPropietarios" 
                    role="button" 
                    aria-expanded="<?= str_contains($current_route, 'owners') ? 'true' : 'false' ?>">
                    <span><i class="fa-solid fa-address-book me-2"></i> PROPIETARIOS</span>
            </a>

            <div class="collapse <?= str_contains($current_route, 'owners') ? 'show' : '' ?>" id="menuPropietarios">
                <div class="d-flex flex-column">
                    <div class="bg-dark bg-opacity-25">
                        <a href="<?= BASE_URL ?>owners" class="nav-link submenu-item text-white-50 p-2 <?= $current_route === 'owners' ? 'active text-white' : '' ?>">
                            <i class="fa-solid fa-list me-2"></i> Listado General
                        </a>
                        <a href="<?= BASE_URL ?>owners/create" class="nav-link submenu-item text-white-50 p-2 <?= $current_route === 'owners/create' ? 'active text-white' : '' ?>">
                            <i class="fa-solid fa-plus me-2"></i> Nuevo Registro
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="p-3 mt-auto">
                <a href="<?= BASE_URL ?>logout" class="logout-link btn btn-outline-light w-100 text-start border-0"
                    onclick="return confirm('¿Deseas cerrar la sesión?')">
                    <i class="fa-solid fa-power-off me-2"></i> Cerrar Sesión
                </a>
            </div>
        </nav>
    </aside>

    <main class="main-content flex-grow-1 bg-light">
        <header class="content-header d-flex justify-content-between align-items-center p-4 bg-white shadow-sm mb-4">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="h4 mb-0 fw-bold text-secondary">
                    Bienvenido, <span class="text-dark"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?></span>
                </h1>
            </div>
            <span class="badge rounded-pill bg-primary px-3 py-2">
                <i class="fa-solid fa-user-shield me-1"></i> <?= strtoupper($_SESSION['user_role'] ?? 'Admin') ?>
            </span>
        </header>

        <section class="container-fluid px-4 pb-4">
            <?php if (!$storedRate): ?>
                <div class="alert alert-warning border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div>
                            <h4 class="alert-heading mb-1">
                                <i class="fa-solid fa- gauge-high me-2"></i> Tasa de Cambio No Establecida
                            </h4>
                            <p class="mb-0 text-muted">
                                No se ha registrado la tasa oficial para el día de hoy (<?= date('d/m/Y') ?>). 
                                Es necesario confirmarla para procesar pagos en divisas.
                            </p>
                        </div>
                        
                        <form action="<?= BASE_URL ?>rates/update" method="POST" class="d-flex gap-2 align-items-center">
                            <div class="input-group">
                                <span class="input-group-text bg-white">Bs.</span>
                                <input type="number" 
                                    step="0.01" 
                                    name="rate_value" 
                                    class="form-control" 
                                    style="width: 110px;" 
                                    value="<?= $bcvRate ?? '' ?>" 
                                    placeholder="0.00" 
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-check me-1"></i> Confirmar
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="mb-4 text-end">
                    <span class="badge bg-success p-2 shadow-sm">
                        <i class="fa-solid fa-money-bill-transfer me-1"></i> 
                        Tasa del día: <strong><?= number_format($storedRate, 2, ',', '.') ?> Bs.</strong>
                    </span>
                </div>
            <?php endif; ?>
            
            <div class="card border-0 shadow-sm p-4">
                <?php 
                    if (isset($content) && file_exists($content)) {
                        include $content;
                    } else {
                        echo '<div class="text-center py-5">
                                <i class="fa-solid fa- chalkboard-user fa-4x text-muted mb-3"></i>
                                <h2 class="h3 fw-bold">Panel de Control</h2>
                                <p class="text-muted">Selecciona una opción del menú lateral para comenzar a gestionar el sistema.</p>
                                </div>';
                    }
                ?>
            </div>
        </section>
    </main>
</div>

<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title"><i class="fa-solid fa-building-shield me-2"></i>Menú de Gestión</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <nav class="nav flex-column">
            <a class="nav-link text-white p-3 border-bottom border-secondary <?= $current_route === 'dashboard' ? 'bg-primary' : '' ?>" 
                href="<?= BASE_URL ?>dashboard">
                <i class="fa-solid fa-chart-line me-2"></i> Inicio
            </a>

            <?php if ($_SESSION['user_role'] === 'super_admin'): ?>
                <a class="nav-link text-white p-3 border-bottom border-secondary d-flex justify-content-between align-items-center" 
                    data-bs-toggle="collapse" 
                    href="#mobileMenuUsuarios" 
                    role="button">
                    <span><i class="fa-solid fa-users-gear me-2"></i> USUARIOS</span>
                </a>
                
                <div class="collapse <?= in_array($current_route, ['users', 'users/create', 'users/inactive']) ? 'show' : '' ?>" id="mobileMenuUsuarios">
                    <div class="bg-secondary bg-opacity-10">
                        <a href="<?= BASE_URL ?>users" class="nav-link text-white-50 ps-5 p-3 border-bottom border-secondary <?= $current_route === 'users' ? 'text-white fw-bold' : '' ?>">
                            <i class="fa-solid fa-list-check me-2"></i> Listar Activos
                        </a>
                        <a href="<?= BASE_URL ?>users/create" class="nav-link text-white-50 ps-5 p-3 border-bottom border-secondary <?= $current_route === 'users/create' ? 'text-white fw-bold' : '' ?>">
                            <i class="fa-solid fa-user-plus me-2"></i> Registrar Nuevo
                        </a>
                        <a href="<?= BASE_URL ?>users/inactive" class="nav-link text-white-50 ps-5 p-3 border-bottom border-secondary <?= $current_route === 'users/inactive' ? 'text-white fw-bold' : '' ?>">
                            <i class="fa-solid fa-user-slash me-2"></i> Inactivos
                        </a>
                    </div>
                </div>

                <a class="nav-link text-white p-3 d-flex justify-content-between align-items-center" 
                    data-bs-toggle="collapse" 
                    href="#menuPropietarios" 
                    role="button" 
                    aria-expanded="<?= str_contains($current_route, 'owners') ? 'true' : 'false' ?>">
                    <span><i class="fa-solid fa-address-book me-2"></i> PROPIETARIOS</span>
                </a>

                <div class="collapse <?= str_contains($current_route, 'owners') ? 'show' : '' ?>" id="menuPropietarios">
                    <div class="bg-dark bg-opacity-25">
                        <a href="<?= BASE_URL ?>owners" class="nav-link text-white-50 ps-5 p-2 <?= $current_route === 'owners' ? 'text-white fw-bold' : '' ?>">
                            <i class="fa-solid fa-list me-2"></i> Listado General
                        </a>
                        <a href="<?= BASE_URL ?>owners/create" class="nav-link text-white-50 ps-5 p-2 <?= $current_route === 'owners/create' ? 'text-white fw-bold' : '' ?>">
                            <i class="fa-solid fa-plus me-2"></i> Nuevo Registro
                        </a>
                    </div>
                </div>
                
            <?php endif; ?>

            

            <a class="nav-link text-danger p-3 mt-auto" onclick="return confirm('¿Deseas cerrar la sesión?')">
                <i class="fa-solid fa-power-off me-2"></i> Cerrar Sesión
            </a>
        </nav>
    </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>