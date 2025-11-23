<?php
error_reporting(0);


require_once('../config/sesiones.php');
require_once("../config/cors.php");
require_once("../models/Empleado.models.php");

$Empleados = new Empleados;

switch ($_GET["op"]) {

    case 'todos':
        $datos = array();
        $datos = $Empleados->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    case 'todosData':
        $todos = array();
        $datos = $Empleados->todosData();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    case 'fechas':
        $inicio = $_POST["inicio"];
        $fin = $_POST["fin"];
        $todos = array();
        $datos = $Empleados->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno':
        $EmpleadoId = $_POST["EmpleadoId"];
        $datos = array();
        $datos = $Empleados->uno($EmpleadoId);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    case 'unoCedula':
        $Cedula = $_POST["Cedula"];
        $datos = array();
        $datos = $Empleados->unoCedula($Cedula);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    case 'contarCedula':
        $Cedula = $_POST["Cedula"];
        $datos = array();
        $datos = $Empleados->contarCedula($Cedula);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    case 'unoCorreo':
        $Correo = $_POST["Correo"];
        $datos = array();
        $datos = $Empleados->unoCorreo($Correo);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        $Nombres = $_POST["Nombres"];
        $Apellidos = $_POST["Apellidos"];
        $Correo = $_POST["Correo"];
        $SucursalId = $_POST["SucursalId"];
        $RolId = $_POST["RolId"];
        $Cedula = $_POST["Cedula"];
        $Direccion = $_POST["Direccion"];
        $Telefono = $_POST["Telefono"];
        $datos = array();
        $datos = $Empleados->Insertar($Nombres, $Apellidos, $Direccion, $Telefono, $Cedula, $Correo, $RolId, $SucursalId);
        echo json_encode($datos);
        break;

    case 'actualizar':
        $EmpleadoId = $_POST["EmpleadoId"];
        $Nombres = $_POST["Nombres"];
        $Apellidos = $_POST["Apellidos"];
        $Correo = $_POST["Correo"];
        $RolId = $_POST["RolId"];
        $Cedula = $_POST["Cedula"];
        $Direccion = $_POST["Direccion"];
        $Telefono = $_POST["Telefono"];
        $SucursalId = $_POST["SucursalId"];
        $datos = array();
        $datos = $Empleados->Actualizar($EmpleadoId, $Nombres, $Apellidos, $Direccion, $Telefono, $Cedula, $Correo, $RolId, $SucursalId);
        echo json_encode($datos);
        break;

    case 'eliminar':
        $EmpleadoId = $_POST["EmpleadoId"];
        $datos = array();
        $datos = $Empleados->Eliminar($EmpleadoId);
        echo json_encode($datos);
        break;


        $correo = $_POST['correo'];
        $contrasenia = $_POST['contrasenia'];


        if (empty($correo) or  empty($contrasenia)) {
            header("Location:../login.php?op=2");
            exit();
        }

        try {
            $datos = array();
            $datos = $Usuarios->login($correo, $contrasenia);
            $res = mysqli_fetch_assoc($datos);
        } catch (Throwable $th) {
            header("Location:../login.php?op=1");
            exit();
        }

        try {
            if (is_array($res) and count($res) > 0) {

                if ((($contrasenia) == ($res["Contrasenia"]))) {


                    $_SESSION["idUsuarios"] = $res["idUsuarios"];
                    $_SESSION["Usuarios_Nombres"] = $res["Nombres"];
                    $_SESSION["Usuarios_Apellidos"] = $res["Apellidos"];
                    $_SESSION["Usuarios_Correo"] = $res["Correo"];
                    $_SESSION["Usuario_IdRoles"] = $res["idRoles"];
                    $_SESSION["Rol"] = $res["Rol"];



                    header("Location:../views/home.php");
                    exit();
                } else {
                    header("Location:../login.php?op=1");
                    exit();
                }
            } else {
                header("Location:../login.php?op=1");
                exit();
            }
        } catch (Exception $th) {
            echo ($th->getMessage());
        }
        break;
}
