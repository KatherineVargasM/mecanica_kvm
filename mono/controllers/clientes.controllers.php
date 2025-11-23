<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

require_once('../config/sesiones.php');
require_once("../models/clientes.models.php");

$Clientes = new Clientes;

switch ($_GET["op"]) {

    case 'todos':
        $datos = $Clientes->todos();
        $lista = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $lista[] = $row;
        }
        echo json_encode($lista);
        break;

    case 'uno':
        $id = $_POST["idCliente"];
        $datos = $Clientes->uno($id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        $nombres = $_POST["nombres"];
        $apellidos = $_POST["apellidos"];
        $telefono = $_POST["telefono"];
        $correo = $_POST["correo_electronico"];
        
        $res = $Clientes->Insertar($nombres, $apellidos, $telefono, $correo);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Cliente guardado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;

    case 'actualizar':
        $id = $_POST["idCliente"];
        $nombres = $_POST["nombres"];
        $apellidos = $_POST["apellidos"];
        $telefono = $_POST["telefono"];
        $correo = $_POST["correo_electronico"];
        
        $res = $Clientes->Actualizar($id, $nombres, $apellidos, $telefono, $correo);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Cliente actualizado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;

    case 'eliminar':
        $id = $_POST["idCliente"];
        $res = $Clientes->Eliminar($id);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Eliminado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;
}
?>