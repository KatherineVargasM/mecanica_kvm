<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

require_once('../config/sesiones.php');
require_once("../models/reportes.models.php");

$Reportes = new Reportes;

switch ($_GET["op"]) {
    
    case 'top_clientes':
        $datos = $Reportes->topClientes();
        $lista = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $lista[] = $row;
        }
        echo json_encode($lista);
        break;
}
?>