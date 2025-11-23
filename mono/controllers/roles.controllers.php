<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

require_once('../config/sesiones.php');
require_once("../models/roles.models.php");

$Roles = new Roles;

switch ($_GET["op"]) {

    case 'todos':
        $datos = $Roles->todos();
        $lista = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $lista[] = $row;
        }
        echo json_encode($lista);
        break;

    case 'uno':
        $id = $_POST["idRol"];
        $datos = $Roles->uno($id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        
        $res = $Roles->Insertar($nombre, $descripcion);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Rol registrado"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;

    case 'actualizar':
        $id = $_POST["idRol"];
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        
        $res = $Roles->Actualizar($id, $nombre, $descripcion);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Rol actualizado"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;

    case 'eliminar':
        $id = $_POST["idRol"];
        $res = $Roles->Eliminar($id);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Rol eliminado"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;
}
?>