<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
error_reporting(0); 

require_once('../config/sesiones.php');
require_once("../models/orden_trabajo.models.php");

$Orden = new OrdenTrabajo();

switch ($_GET["op"]) {

    case 'todos':
        $datos = $Orden->todos();
        $lista = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $lista[] = $row;
        }
        echo json_encode($lista);
        break;

    case 'unoServicio':
        $idServicio = $_POST["idServicio"];
        $datos = $Orden->uno($idServicio);
        echo json_encode([
            "servicio" => $datos["cabecera"],
            "items" => $datos["items"]
        ]);
        break;

    case 'insertar':
        $id_vehiculo = $_POST["id_vehiculo"];
        $id_usuario = $_POST["id_usuario"];
        $fecha = $_POST["fecha_servicio"];
        $items = json_decode($_POST["items"], true);
        
        $res = $Orden->Insertar($id_vehiculo, $id_usuario, $fecha, $items);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;

    case 'actualizar':
        $idServicio = $_POST["id"];
        $id_vehiculo = $_POST["id_vehiculo"];
        $id_usuario = $_POST["id_usuario"];
        $fecha = $_POST["fecha_servicio"];
        $items = json_decode($_POST["items"], true);
        
        $res = $Orden->Actualizar($idServicio, $id_vehiculo, $id_usuario, $fecha, $items);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;

    case 'eliminar':
        $idServicio = $_POST["idServicio"];
        $res = $Orden->Eliminar($idServicio);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;
}
?>