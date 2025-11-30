<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');

require_once('../config/sesiones.php');
require_once("../models/tipo_serivicio.models.php");

$Tipo_Servicio = new Tipo_Servicio;

if (!isset($_GET["op"])) {
    echo json_encode(["error" => "No operation specified"]);
    exit();
}

switch ($_GET["op"]) {

    case 'todos':
        $datos = array();
        $datos = $Tipo_Servicio->todos();

        $datoshtml = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $unafila = array();
            $unafila[] = $row["id"]; 
            $unafila[] = $row["detalle"];
            $unafila[] = $row["valor"];
            $unafila[] = ($row["estado"] == 1) 
                ? '<span class="badge bg-success">Activo</span>' 
                : '<span class="badge bg-danger">Inactivo</span>';
            
            $unafila[] = '
                <button class="btn btn-primary btn-sm" onclick="uno(' . $row["id"] . ')" title="Editar">
                    <i class="bx bx-edit"></i>
                </button>
                <button class="btn btn-danger btn-sm" onclick="eliminar(' . $row["id"] . ')" title="Eliminar">
                    <i class="bx bx-trash"></i>
                </button>
                <button class="btn btn-warning btn-sm" onclick="eliminarsuave(' . $row["id"] . ')" title="Desactivar">
                    <i class="bx bx-user-x"></i>
                </button>';
            
            $datoshtml[] = $unafila;
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($datoshtml),
            "iTotalDisplayRecords" => count($datoshtml),
            "aaData" => $datoshtml
        );
        echo json_encode($resultados);
        break;

    case 'uno':
        $idTipoServicio = $_POST["id_tipo_servicio"];
        $datos = $Tipo_Servicio->uno($idTipoServicio);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        $detalle = $_POST["detalle"];
        $valor = $_POST["valor"];
        $datos = $Tipo_Servicio->Insertar($detalle, $valor);
        echo json_encode($datos);
        break;

    case 'actualizar':
        $idTipoServicio = $_POST["idTipoServicio"];
        $detalle = $_POST["detalle"];
        $valor = $_POST["valor"];
        
        $estado = ($_POST["estado"] === "on" || $_POST["estado"] === "1" || $_POST["estado"] === 1) ? 1 : 0;
            
        $datos = $Tipo_Servicio->Actualizar($idTipoServicio, $detalle, $valor, $estado);
        echo json_encode($datos);
        break;

    case 'eliminar':
        $idTipoServicio = $_POST["idTipoServicio"];
        $datos = $Tipo_Servicio->Eliminar($idTipoServicio);
        echo json_encode($datos);
        break;

    case 'eliminarsuave':
        $idTipoServicio = $_POST["idTipoServicio"];
        $datos = $Tipo_Servicio->Eliminarsuave($idTipoServicio);
        echo json_encode($datos);
        break;
        
    case 'imprimir':
        break;
}
?>