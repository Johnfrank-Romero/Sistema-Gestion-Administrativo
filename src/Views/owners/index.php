<?php

    use App\Services\AuthService;
?>

<div class="container-fluid fw-normal">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa-solid fa-address-book text-primary me-2"></i>Gestión de Propietarios
        </h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Listado General de Propietarios</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" style="width: 150px;">RIF / Cédula</th>
                            <th>Nombre Completo / Razón Social</th>
                            <th>Contacto</th>
                            <th>Correo Electrónico</th>
                            <th class="text-center" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($owners)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-folder-open d-block fs-1 mb-2 opacity-25"></i>
                                    No se encontraron propietarios registrados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($owners as $owner): ?>
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-secondary opacity-75 fw-medium">
                                            <?= htmlspecialchars($owner->rif) ?>
                                        </span>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        <?= htmlspecialchars($owner->name) ?>
                                    </td>
                                    <td>
                                        <div class="small text-muted">
                                            <i class="fa-solid fa-phone me-1"></i>
                                            <?= $owner->phone ? htmlspecialchars($owner->phone) : '<em>No asignado</em>' ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="fa-solid fa-envelope me-1 text-muted"></i>
                                            <?= $owner->email ? htmlspecialchars($owner->email) : '<span class="text-muted small">Sin correo</span>' ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm">
                                            <a href="<?= BASE_URL ?>owners/edit/<?= $owner->id ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            
                                            <?php if (AuthService::isSuperAdmin()): ?>
                                                <a href="<?= BASE_URL ?>owners/delete/<?= $owner->id ?>" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('¿Estás seguro de eliminar a este propietario?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>