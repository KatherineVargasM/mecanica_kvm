<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">RegAsis /</span> Clientes</h4>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Clientes</h5>
        <button type="button" class="btn btn-primary" onclick="nuevo()">
            <i class="bx bx-plus me-1"></i> Nuevo Cliente
        </button>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="ListaClientes">
                </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="ModalClientes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="LimpiarCajas()"></button>
            </div>

            <form id="form_clientes" method="post">
                <input type="hidden" name="idCliente" id="idCliente">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Ingrese nombres" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ingrese apellidos" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="0999999999">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                            <input type="email" name="correo_electronico" id="correo_electronico" class="form-control" placeholder="cliente@correo.com">
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
<script src="./clientes.js"></script>