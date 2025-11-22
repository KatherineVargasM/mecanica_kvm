<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">RegAsis /</span> Orden de Trabajo</h4>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Órdenes</h5>
        <button type="button" class="btn btn-primary" onclick="nuevaOrden()">
             <i class="bx bx-plus me-1"></i> Nueva Orden
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="tablaOrdenesTrabajo">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Vehículo</th>
                        <th>Usuario (Responsable)</th>
                        <th>Cant. Servicios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="ListaOrdenesTrabajo"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="ModalOrdenTrabajo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">Nueva Orden</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="LimpiarFormularioOrden()"></button>
            </div>
            <form id="form_orden_trabajo" method="post">
                <input type="hidden" name="idServicio" id="idServicio">
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-header">Datos Generales</div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Vehículo</label>
                                    <select name="id_vehiculo" id="id_vehiculo" class="form-control" required></select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Usuario Responsable</label>
                                    <select name="id_usuario" id="id_usuario_servicio" class="form-control" required></select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Fecha</label>
                                    <input type="date" name="fecha_servicio" id="fecha_servicio" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Detalle de Servicios</span>
                            <button type="button" class="btn btn-sm btn-primary" id="btnAgregarItem"><i class="bx bx-plus"></i> Agregar</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Tipo Servicio</th>
                                        <th>Técnico</th>
                                        <th>Fecha</th>
                                        <th>Borrar</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyItemsOrden"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="LimpiarFormularioOrden()">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('../html/scripts2.php') ?>
<script src="./orden_trabajo.js"></script>