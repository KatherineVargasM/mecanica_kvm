<?php

require_once("../config/cors.php");
require_once("../models/tipo.models.php");
error_reporting(0);

$TipoAcceso = new TipoAcceso;
switch ($_GET["op"]) {

    case 'todos':
        $data = array();
        $datos = $TipoAcceso->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno':
        $IdTipoAcceso = $_POST["IdTipoAcceso"];
        $datos = array();
        $datos = $TipoAcceso->uno($IdTipoAcceso);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':

        $Detalle = $_POST["Detalle"];

        $datos = array();
        $datos = $TipoAcceso->Insertar($Detalle);
        echo json_encode($datos);
        break;

    case 'actualizar':
        $IdTipoAcceso = $_POST["IdTipoAcceso"];
        $Detalle = $_POST["Detalle"];
        $datos = array();
        $datos = $TipoAcceso->Actualizar($IdTipoAcceso, $Detalle);
        echo json_encode($datos);
        break;

    case 'eliminar':
        $IdTipoAcceso = $_POST["IdTipoAcceso"];
        $datos = array();
        $datos = $TipoAcceso->Eliminar($IdTipoAcceso);
        echo json_encode($datos);
        break;
}
