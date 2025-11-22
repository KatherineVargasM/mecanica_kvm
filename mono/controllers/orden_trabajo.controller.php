<?php

require_once('../config/sesiones.php');
require_once("../models/servicios.models.php");
require_once("../models/orden_trabajo.models.php");

$Servicios    = new Servicios;
$OrdenTrabajo = new OrdenTrabajo;

switch ($_GET["op"]) {

    case 'todos':
        $datos = array();
        $datos = $OrdenTrabajo->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno':
        $idOrdenTrabajo = $_POST["idOrdenTrabajo"];
        $datos = array();
        $datos = $OrdenTrabajo->uno($idOrdenTrabajo);
        $res   = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':


        $id_vehiculo     = $_POST["id_vehiculo"];
        $id_usuario_serv = $_POST["id_usuario"]; 
        $fecha_servicio  = isset($_POST["fecha_servicio"]) ? $_POST["fecha_servicio"] : null;
        $itemsJson = isset($_POST["items"]) ? $_POST["items"] : "[]";
        $items     = json_decode($itemsJson, true);

        $respuesta = array(
            "ok"         => false,
            "mensaje"    => "",
            "idServicio" => null
        );

        $idServicio = $Servicios->InsertarRetornarId($id_vehiculo, $id_usuario_serv, $fecha_servicio);
        echo $idServicio. " id se servicio";
        if ($idServicio <= 0) {
            $respuesta["ok"]      = false;
            $respuesta["mensaje"] = "Error al insertar el servicio";
            echo json_encode($respuesta);
            break;
        }

        $errores = 0;
        if (is_array($items)) {
            foreach ($items as $item) {
                $Descripcion     = $item["descripcion"];
                $TipoServicio_Id = $item["tipo_servicio_id"];
                $Usuario_Id      = $item["usuario_id"];
                $fechaItem       = isset($item["fecha"]) && $item["fecha"] != "" 
                                    ? $item["fecha"] 
                                    : ($fecha_servicio != null ? $fecha_servicio : date('Y-m-d'));

                $resItem = $OrdenTrabajo->Insertar(
                    $Descripcion,
                    $idServicio,
                    $TipoServicio_Id,
                    $Usuario_Id,
                    $fechaItem
                );

                if ($resItem != 'ok') {
                    $errores++;
                }
            }
        }

        if ($errores == 0) {
            $respuesta["ok"]         = true;
            $respuesta["mensaje"]    = "Orden de trabajo registrada correctamente";
            $respuesta["idServicio"] = $idServicio;
        } else {
            $respuesta["ok"]         = false;
            $respuesta["mensaje"]    = "Se registró el servicio pero hubo errores en algunos ítems de la orden de trabajo";
            $respuesta["idServicio"] = $idServicio;
        }

        echo json_encode($respuesta);
        break;

    case 'actualizar':
        $idOrdenTrabajo = $_POST["idOrdenTrabajo"];
        $Descripcion    = $_POST["Descripcion"];
        $Servicio_Id    = $_POST["Servicio_Id"];
        $TipoServicio_Id= $_POST["TipoServicio_Id"];
        $Usuario_Id     = $_POST["Usuario_Id"];
        $fecha          = $_POST["fecha"];

        $datos = array();
        $datos = $OrdenTrabajo->Actualizar(
            $idOrdenTrabajo,
            $Descripcion,
            $Servicio_Id,
            $TipoServicio_Id,
            $Usuario_Id,
            $fecha
        );
        echo json_encode($datos);
        break;

    case 'eliminar':
        $idOrdenTrabajo = $_POST["idOrdenTrabajo"];
        $datos = array();
        $datos = $OrdenTrabajo->Eliminar($idOrdenTrabajo);
        echo json_encode($datos);
        break;

    default:
        break;
}
