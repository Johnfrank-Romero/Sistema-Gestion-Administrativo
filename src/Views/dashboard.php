<?php

    include __DIR__ . '/layouts/header.php'; 

    //Obtener ruta para saber cual enlace marcar//
    $current_route = str_replace(BASE_URL, '', $_SERVER['REQUEST_URI']);
    $current_route = explode('?', $current_route)[0];
    $current_route = trim($current_route, '/');
?>

<div class="dashboard-container">
    <aside class="sidebar">
        <h3><i class="fa-solid fa-building-shield"></i>Gestión Administrativo.</h3>
        <nav>
            <a href="<?= BASE_URL ?>dashboard" class="<?= $current_route === 'dashboard' ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-line"></i> Inicio
            </a>
            
            <?php if ($_SESSION['user_role'] === 'super_admin'): ?>
                <h3><i class="fa-solid fa-users-gear"></i> Usuarios</h3>
                <a href="<?= BASE_URL ?>users" class="<?= $current_route === 'users' ? 'active' : '' ?>">
                    <i class="fa-solid fa-list-check"></i> Listar Activos
                </a>
                <a href="<?= BASE_URL ?>users/create" class="<?= $current_route === 'users/create' ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-plus"></i> Registrar Nuevo
                </a>
                <a href="<?= BASE_URL ?>users/inactive" class="<?= $current_route === 'users/inactive' ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-slash"></i> Inactivos
                </a>
            <?php endif; ?>

            <div class="sidebar-divider"></div>
            
            <a href="<?= BASE_URL ?>logout" class="logout-link">
                <i class="fa-solid fa-power-off"></i> Cerrar Sesión
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="content-header">
            <h1>Bienvenido, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?></h1>
            <span class="role-badge"><?= strtoupper($_SESSION['user_role'] ?? 'Admin') ?></span>
        </header>

        <section class="view-container">
            <?php 
                if (isset($content) && file_exists($content)) {
                    include $content;
                } else {
                    echo '<div class="welcome-card">
                            <h2>Panel de Control</h2>
                            <p>Selecciona una opción del menú para gestionar la asociación.</p>
                        </div>';
                }
            ?>
        </section>
    </main>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>