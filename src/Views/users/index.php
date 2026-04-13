<div class="table-header">
    <h2><i class="fa-solid fa-users"></i> Gestión de Usuarios Activos</h2>
    <p>Administradores registrados que tienen acceso actual al sistema.</p>
</div>

<?php if (isset($_SESSION['success']) && strpos($_SESSION['success'], 'Contraseña temporal') !== false): ?>
    <div class="key-card">
        <div>
            <i class="fa-solid fa-circle-info"></i> 
            <span><?= $_SESSION['success'] ?></span>
        </div>
        <small><i class="fa-solid fa-copy"></i> Copie esta clave ahora.</small>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<table class="data-table">
    <thead>
        <tr>
            <th><i class="fa-solid fa-user"></i> Nombre Completo</th>
            <th><i class="fa-solid fa-envelope"></i> Correo Electrónico</th>
            <th><i class="fa-solid fa-id-badge"></i> Rol</th>
            <th><i class="fa-solid fa-calendar-day"></i> Estado</th>
            <th style="text-align: center;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($users)): ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem; color: #666;">
                    No hay usuarios activos registrados.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user->firstName . ' ' . $user->lastName) ?></td>
                    <td><?= htmlspecialchars($user->email) ?></td>
                    <td>
                        <span class="role-badge">
                            <?= strtoupper($user->role) ?>
                        </span>
                    </td>
                    <td>
                        <span style="color: #27ae60; font-weight: bold;">
                            <i class="fa-solid fa-circle-check"></i> Activo
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="<?= BASE_URL ?>users/reset/<?= $user->id ?>" 
                            class="btn-action btn-reset" 
                            title="Generar nueva clave temporal"
                            onclick="return confirm('¿Estás seguro de resetear la contraseña de este usuario?')">
                            <i class="fa-solid fa-key"></i>
                        </a>

                        <?php if ($user->id !== $_SESSION['user_id']): ?>
                            <a href="<?= BASE_URL ?>users/delete/<?= $user->id ?>" 
                                class="btn-action btn-deactivate" 
                                title="Inhabilitar usuario"
                                onclick="return confirm('¿Deseas inhabilitar a este usuario? Ya no podrá acceder al sistema.')">
                                <i class="fa-solid fa-user-slash"></i>
                            </a>
                        <?php else: ?>
                            <span title="No puedes desactivarte a ti mismo" style="color: #ccc; cursor: not-allowed;">
                                <i class="fa-solid fa-user-lock"></i>
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>