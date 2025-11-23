<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">RegAsis /</span> Reportes</h4>

<div class="card">
    <h5 class="card-header">Clientes Recurrentes</h5>
    
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th class="text-center">Cantidad de Visitas</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="ListaReporte">
                </tbody>
        </table>
    </div>
</div>

<?php require_once('../html/scripts2.php') ?>
<script src="./reportes.js"></script>