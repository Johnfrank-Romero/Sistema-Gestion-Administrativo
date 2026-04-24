<div class="mb-4">
    <h2 class="fw-bold mb-1"><i class="fa-solid fa-user-slash text-danger me-2"></i>Administradores Inhabilitados</h2>
    <p class="text-muted small">Cuentas que han sido desactivadas y no pueden acceder al sistema.</p>
</div>

<div class="table-responsive shadow-sm rounded">
    <table class="table table-hover align-middle bg-white mb-0">
        <thead class="table-light">
            <tr>
                <th class="py-3">Nombre y Apellido</th>
                <th class="py-3">Correo Electrónico</th>
                <th class="py-3">Fecha de Baja</th>
                <th class="py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-user-check fa-3x mb-3 d-block"></i>
                        No hay usuarios inactivos en este momento.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->firstName . ' ' . $user->lastName) ?></td>
                        <td><?= htmlspecialchars($user->email) ?></td>
                        <td class="text-muted">
                            <i class="fa-regular fa-calendar-minus me-1"></i>
                            <?= date('d/m/Y H:i', strtotime($user->deletedAt)) ?>
                        </td>
                        <td class="text-center">
                            <a href="<?= BASE_URL ?>users/activate/<?= $user->id ?>" 
                                class="btn btn-success btn-sm shadow-sm px-3" 
                                onclick="return confirm('¿Deseas reactivar a este usuario?')">
                                <i class="fa-solid fa-user-check me-1"></i> Reactivar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>