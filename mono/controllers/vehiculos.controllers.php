<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
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

    case 'uno':
        $id = $_POST["idVehiculo"];
        $datos = $Vehiculos->uno($id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        $id_cliente = $_POST["id_cliente"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $anio = $_POST["anio"];
        $tipo_motor = $_POST["tipo_motor"];
        
        $res = $Vehiculos->Insertar($id_cliente, $marca, $modelo, $anio, $tipo_motor);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Vehículo guardado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;

    case 'actualizar':
        $id = $_POST["idVehiculo"];
        $id_cliente = $_POST["id_cliente"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $anio = $_POST["anio"];
        $tipo_motor = $_POST["tipo_motor"];
        
        $res = $Vehiculos->Actualizar($id, $id_cliente, $marca, $modelo, $anio, $tipo_motor);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Vehículo actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;

    case 'eliminar':
        $id = $_POST["idVehiculo"];
        $res = $Vehiculos->Eliminar($id);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;
}
?>