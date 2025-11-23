<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">RegAsis /</span> Vehículos</h4>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Vehículos</h5>
        <button type="button" class="btn btn-primary" onclick="nuevo()">
            <i class="bx bx-plus me-1"></i> Nuevo Vehículo
        </button>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Motor</th>
                    <th>Cliente (Dueño)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="ListaVehiculos">
                </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="ModalVehiculos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">Nuevo Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="LimpiarCajas()"></button>
            </div>

            <form id="form_vehiculos" method="post">
                <input type="hidden" name="idVehiculo" id="idVehiculo">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_cliente" class="form-label">Cliente</label>
                            <select name="id_cliente" id="id_cliente" class="form-control" required>
                                </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="marca" class="form-label">Marca</label>
                            <input type="text" name="marca" id="marca" class="form-control" placeholder="Ej: Toyota" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Ej: Yaris" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" name="anio" id="anio" class="form-control" placeholder="2023" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="tipo_motor" class="form-label">Tipo Motor</label>
                            <select name="tipo_motor" id="tipo_motor" class="form-control" required>
                                <option value="">Seleccione...</option>
                                <option value="dos_tiempos">Dos Tiempos</option>
                                <option value="cuatro_tiempos">Cuatro Tiempos</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="LimpiarCajas()">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('../html/scripts2.php') ?>
<script src="./vehiculos.js"></script>