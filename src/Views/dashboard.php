<?php if (isset($_SESSION['user_name'])): ?>
    <span>Bienvenido, <?= $_SESSION['user_name'] ?></span>
    <a href="<?= BASE_URL ?>index.php?action=logout">Cerrar Sesión</a>
<?php endif; ?>