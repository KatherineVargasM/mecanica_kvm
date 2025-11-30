<?php 
require_once('../html/head2.php');
require_once('../../config/sesiones.php'); 
?>

<style>
    @media print {
        button, .btn {
            display: none !important;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size: 0.9rem;
        }
        .table th,
        .table td {
            padding: 0.5rem 0.75rem;
            border-top: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            background-color: #f8f9fa;
            font-weight: 600;
            text-align: left;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th {
            border-bottom-width: 2px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }


        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        .table tbody tr td {
            color: #212529;
        }

        .table thead th {
            color: #212529;
        }

        @media (max-width: 576px) {
            .table th,
            .table td {
                padding: 0.4rem 0.5rem;
                font-size: 0.8rem;
            }
        }
    }
</style>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">RegAsis /</span> Servicios de Mecánica</h4>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Servicios de Mecánica</h5>
        
        <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary" onclick="LimpiarCajas()" data-bs-toggle="modal" data-bs-target="#ModalTipo_Servicio">
                Nuevo Servicio de Mecánica
            </button>

            <button class="btn btn-success" onclick="imprimirTabla()">Imprimir</button>
            
            <a class="btn btn-primary" href="../../controllers/tipo_servicio.controllers.php?op=imprimir" target="_blank">
                Imprimir con fpdf
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