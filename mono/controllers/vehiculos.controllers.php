<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

require_once('../config/sesiones.php');
require_once("../models/vehiculos.models.php");

$Vehiculos = new Vehiculos;

switch ($_GET["op"]) {
    case 'todos':
        $datos = $Vehiculos->todos();
        $lista = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $lista[] = $row;
        }
        echo json_encode($lista);
        break;
}
?>