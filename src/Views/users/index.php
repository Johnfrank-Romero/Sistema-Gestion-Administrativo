<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold mb-1"><i class="fa-solid fa-users text-primary me-2"></i>Gestión de Usuarios Activos</h2>
        <p class="text-muted small mb-0">Administradores registrados con acceso actual al sistema.</p>
    </div>
</div>

<div class="table-responsive shadow-sm rounded">
    <table class="table table-hover align-middle bg-white mb-0">
        <thead class="table-light">
            <tr>
                <th class="py-3"><i class="fa-solid fa-user me-2"></i>Nombre y Apellido</th>
                <th class="py-3"><i class="fa-solid fa-envelope me-2"></i>Correo Electrónico</th>
                <th class="py-3"><i class="fa-solid fa-id-badge me-2"></i>Rol</th>
                <th class="py-3 text-center">Estado</th>
                <th class="py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-folder-open fa-3x mb-3 d-block"></i>
                        No hay usuarios activos registrados.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="fw-semibold"><?= htmlspecialchars($user->firstName . ' ' . $user->lastName) ?></td>
                        <td><?= htmlspecialchars($user->email) ?></td>
                        <td>
                            <?php if ($user->role === 'super_admin'): ?>
                                <span class="badge rounded-pill badge-super-admin px-3">
                                    <i class="fa-solid fa-crown me-1"></i> SUPER_ADMIN
                                </span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-secondary px-3">
                                    ADMIN
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3">
                                <i class="fa-solid fa-circle-check me-1"></i> Activo
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="<?= BASE_URL ?>users/reset/<?= $user->id ?>" 
                                    class="btn btn-sm btn-warning shadow-sm" 
                                    title="Resetear clave"
                                    onclick="return confirm('¿Estás seguro de resetear la contraseña?')">
                                    <i class="fa-solid fa-key"></i>
                                </a>

                                <?php if ($user->id !== $_SESSION['user_id']): ?>
                                    <a href="<?= BASE_URL ?>users/delete/<?= $user->id ?>" 
                                        class="btn btn-sm btn-danger shadow-sm" 
                                        title="Inhabilitar"
                                        onclick="return confirm('¿Deseas inhabilitar a este usuario?')">
                                        <i class="fa-solid fa-user-slash"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-light border" disabled title="No puedes desactivarte a ti mismo">
                                        <i class="fa-solid fa-user-lock"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>