<?php

require_once("../config/cors.php");
require_once("../models/rol.models.php");
error_reporting(0);

$Rolvariable = new Rol;
switch ($_GET["op"]) {

    case 'todos':
        $datos = array();
        $datos = $Rolvariable->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);

        break;

    case 'uno':
        $idRoles = $_POST["idRoles"];
        $datos = array();
        $datos = $Rolvariable->uno($idRoles);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        $Rol = $_POST["Rol"];
        $datos = array();
        $datos = $Rolvariable->insertar($Rol);
        echo json_encode($datos);
        break;

    case 'actualizar':
        $idRoles = $_POST["idRoles"];
        $Rol = $_POST["Rol"];
        $datos = array();
        $datos = $Rolvariable->actualizar($idRoles, $Rol);
        echo json_encode($datos);
        break;

    case 'eliminar':
        $idRoles = $_POST["idRoles"];
        $datos = array();
        $datos = $Rolvariable->Eliminar($idRoles);
        echo json_encode($datos);
        break;
}
