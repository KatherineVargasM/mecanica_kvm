<?php 
require_once('../html/head2.php');
require_once('../../config/sesiones.php'); 
?>

<style>

    #botones_accion .btn {
        margin: 0 !important;
        border-radius: 0 !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0.375rem 0.75rem;
        color: white !important;
    }

    #botones_accion .btn:first-child {
        border-top-left-radius: 4px !important;
        border-bottom-left-radius: 4px !important;
    }
    #botones_accion .btn:last-child {
        border-top-right-radius: 4px !important;
        border-bottom-right-radius: 4px !important;
    }

    #botones_accion .btn-success {
        background-color: #71d329 !important; 
    }
    #botones_accion .btn-success:hover {
        background-color: #5fb322 !important;
    }

    #botones_accion .btn-primary {
        background-color: #0055a5 !important;
    }
    #botones_accion .btn-primary:hover {
        background-color: #004485 !important;
    }

    @media print {
        button, .btn, .dt-buttons, #botones_accion {
            display: none !important;
        }
        .table-responsive { width: 100%; overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; background-color: #fff; font-size: 0.9rem; }
        .table th, .table td { padding: 0.5rem; border: 1px solid #dee2e6; }
        .table thead th { background-color: #f8f9fa; }
    }
</style>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">RegAsis /</span> Servicios de Mecánica</h4>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Servicios de Mecánica</h5>
        
        <button type="button" class="btn btn-primary" onclick="LimpiarCajas()" data-bs-toggle="modal" data-bs-target="#ModalTipo_Servicio">
            + Nuevo Servicio
        </button>
    </div>

    <div class="card-body">
        
        <div class="mb-3">
             <div id="botones_accion" class="btn-group" role="group" aria-label="Acciones de tabla">
                <button class="btn btn-primary" onclick="imprimirTabla()">Imprimir</button>
                <a class="btn btn-success" href="../../controllers/tipo_servicio.controllers.php?op=imprimir" target="_blank">
                    Imprimir FPDF
                </a>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-striped table-hover" id="Tabla_Tipo_Servicio">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Detalle</th>
                        <th>Valor</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalTipo_Servicio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal"> Nuevo Servicio de Mecánica </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form_tipo_servicio" method="post">
                <input type="hidden" name="idTipoServicio" id="idTipoServicio">
                
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="detalle" class="form-label">Detalle</label>
                        <input type="text" name="detalle" id="detalle" class="form-control" placeholder="Ingrese el detalle del servicio" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="valor" class="form-label">Valor</label>
                        <input type="text" name="valor" id="valor" class="form-control" placeholder="Ingrese el valor del servicio" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="estado" class="form-label">Estado</label>
                        <div class="form-check form-switch">
                            <input name="estado" id="estado" onchange="updateEstadoLabel()" class="form-check-input" type="checkbox" role="switch">
                            <label class="form-check-label" for="estado" id="lblEstado">No Activo</label>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('../html/scripts2.php') ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script src="./tipo_servicio.js"></script>