<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

require_once('../config/sesiones.php');
require_once("../models/empleado.models.php");

$Empleados = new Empleados;

switch ($_GET["op"]) {

    case 'todos':
        $datos = $Empleados->todos();
        $lista = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $lista[] = $row;
        }
        echo json_encode($lista);
        break;

    case 'uno':
        $id = $_POST["idEmpleado"];
        $datos = $Empleados->uno($id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        $cedula = $_POST["cedula"];
        $nombres = $_POST["nombres"];
        $apellidos = $_POST["apellidos"];
        $correo = $_POST["correo"];
        $telefono = $_POST["telefono"];
        $cargo = $_POST["cargo"];
        
        $res = $Empleados->Insertar($cedula, $nombres, $apellidos, $correo, $telefono, $cargo);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Empleado registrado"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;

    case 'actualizar':
        $id = $_POST["idEmpleado"];
        $cedula = $_POST["cedula"];
        $nombres = $_POST["nombres"];
        $apellidos = $_POST["apellidos"];
        $correo = $_POST["correo"];
        $telefono = $_POST["telefono"];
        $cargo = $_POST["cargo"];
        
        $res = $Empleados->Actualizar($id, $cedula, $nombres, $apellidos, $correo, $telefono, $cargo);
        
        if($res == "ok"){
            echo json_encode(["status" => "ok", "mensaje" => "Empleado actualizado"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $res]);
        }
        break;

    case 'eliminar':
        $id = $_POST["idEmpleado"];
        $res = $Empleados->Eliminar($id);
        if($res == "ok") echo json_encode(["status" => "ok"]);
        else echo json_encode(["status" => "error", "mensaje" => $res]);
        break;

    case 'eliminarsuave':
        $id = $_POST["idEmpleado"];
        $res = $Empleados->EliminarSuave($id);
        if($res == "ok") echo json_encode(["status" => "ok"]);
        else echo json_encode(["status" => "error", "mensaje" => $res]);
        break;
}
?>