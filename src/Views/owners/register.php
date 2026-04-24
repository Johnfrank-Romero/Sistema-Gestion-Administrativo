<div class="container-fluid fw-normal">
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa-solid fa-user-plus text-primary me-2"></i>Registrar Nuevo Propietario
        </h1>
        <p class="text-muted">Complete los datos del propietario para darlo de alta en el sistema.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Formulario de Registro</h6>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>owners/store" method="POST" class="needs-validation">
                        
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="rif" class="form-label fw-bold">RIF / Cédula <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-id-card"></i></span>
                                    <input type="text" class="form-control" id="rif" name="rif" 
                                            placeholder="Ej: V-123456780" required
                                            oninput="this.value = this.value.toUpperCase()">
                                </div>
                            </div>

                            <div class="col-md-7">
                                <label for="name" class="form-label fw-bold">Nombre Completo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" class="form-control" id="name" name="name" 
                                            placeholder="Nombre o Razón Social" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold">Teléfono de Contacto</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" class="form-control" id="phone" name="phone" 
                                            placeholder="Ej: 0414-1234567">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" 
                                            placeholder="correo@ejemplo.com">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-center gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Propietario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="alert alert-info border-0 shadow-sm small">
                <i class="fa-solid fa-circle-info me-2"></i>
                Los campos marcados con un asterisco (<span class="text-danger">*</span>) son de carácter obligatorio para el registro.
            </div>
        </div>
    </div>
</div>