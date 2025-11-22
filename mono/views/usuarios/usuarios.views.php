<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">RegAsis /</span> Usuarios</h4>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Usuarios</h5>
        <button type="button" class="btn btn-primary" onclick="nuevo()" data-bs-toggle="modal" data-bs-target="#ModalUsuarios">
            <i class="bx bx-plus me-1"></i> Nuevo Usuario
        </button>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre de Usuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="ListaUsuarios">
                </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="ModalUsuarios" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="LimpiarCajas()"></button>
            </div>

            <form id="form_usuarios" method="post">
                <input type="hidden" name="idUsuarios" id="idUsuarios">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="NombreUsuario" class="form-label">Nombres</label>
                            <input type="text" name="NombreUsuario" id="NombreUsuario" class="form-control" placeholder="Ingrese nombre de usuario" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="id_rol" class="form-label">Rol</label>
                            <select id="id_rol" name="id_rol" class="form-select" required>
                                </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="contrasenia" class="form-label">Contraseña</label>
                            <input type="password" name="contrasenia" id="contrasenia" class="form-control" placeholder="**********" required>
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
<script src="./usuarios.js"></script>