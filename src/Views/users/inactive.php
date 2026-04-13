<div class="table-container">
    <h2><i class="fa-solid fa-user-slash"></i> Administradores Inhabilitados</h2>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Inhabilitado el</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="4" style="text-align:center;">No hay usuarios inactivos.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->firstName . ' ' . $user->lastName) ?></td>
                        <td><?= htmlspecialchars($user->email) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($user->deletedAt)) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>users/activate/<?= $user->id ?>" class="btn-action activate" title="Reactivar">
                                <i class="fa-solid fa-user-check"></i> Reactivar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>