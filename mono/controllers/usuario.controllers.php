<?php
error_reporting(0);
/*TODO: Requerimientos */
require_once('../config/sesiones.php');
require_once("../models/usuario.models.php");

$Usuarios = new Usuarios;

switch ($_GET["op"]) {
        /*TODO: Procedimiento para listar todos los registros */
    case 'todos':
        $datos = array();
        $datos = $Usuarios->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
        /*TODO: Procedimiento para sacar un registro */
    case 'uno':
        $idUsuarios = $_POST["idUsuarios"];
        $datos = array();
        $datos = $Usuarios->uno($idUsuarios);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    case 'unoNombreUsuario':
        $NombreUsuario = $_POST["NombreUsuario"];
        $datos = array();
        $datos = $Usuarios->unoNombreUsuario($NombreUsuario);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    
    case 'insertar':
        $NombreUsuario = $_POST["NombreUsuario"];
        $Contrasenia = $_POST["contrasenia"];
        $id_rol = $_POST["id_rol"];
        $datos = array();
        $datos = $Usuarios->Insertar($NombreUsuario,  md5($Contrasenia),  $id_rol, 'curdate()');
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para actualizar */
    case 'actualizar':
        $idUsuarios = $_POST["idUsuarios"];
        $nombre_usuario = $_POST["nombre_usuario"];
        $contrasena = $_POST["contrasena"];
        $id_rol = $_POST["id_rol"];
        $datos = array();
        $datos = $Usuarios->Actualizar($idUsuarios, $nombre_usuario, $contrasena, $id_rol, 'curdate()');
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para eliminar */
    case 'eliminar':
        $idUsuarios = $_POST["idUsuarios"];
        $datos = array();
        $datos = $Usuarios->Eliminar($idUsuarios);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para insertar */
    case 'login2':
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasenia = $_POST['contrasenia'];

        //TODO: Si las variables estab vacias rgersa con error
        if (empty($nombre_usuario) or  empty($contrasenia)) {
            header("Location:../login.php?op=2");
            exit();
        }

        try {
            $datos = array();
            $datos = $Usuarios->login($nombre_usuario, $contrasenia);
            $res = mysqli_fetch_assoc($datos);
        } catch (Throwable $th) {
            header("Location:../login.php?op=1");
            exit();
        }
        //TODO:Control de si existe el registro en la base de datos
        try {
            if (is_array($res) and count($res) > 0) {
                //if ((md5($contrasenia) == ($res["Contrasenia"]))) {
                if ((md5($contrasenia) == ($res["Contrasenia"]))) {
                    //$datos2 = array();
                    // $datos2 = $Accesos->Insertar(date("Y-m-d H:i:s"), $res["idUsuarios"], 'ingreso');

                    $_SESSION["idUsuarios"] = $res["idUsuarios"];
                    $_SESSION["Usuarios_Nombres"] = $res["Nombres"];
                   
                    $_SESSION["Usuario_IdRoles"] = $res["idRoles"];
                    $_SESSION["Rol"] = $res["Rol"];

                    if ($res["Rol"] == 'Control') {
                        header("Location:../views/control.php");
                    } else {
                        header("Location:../views/home.php");
                    }
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
    case 'login1':   // para para inyeccion sql 
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasenia = $_POST['contrasenia'];

        //TODO: Si las variables estab vacias rgersa con error
        if (empty($nombre_usuario) or  empty($contrasenia)) {
            header("Location:../login.php?op=2");
            exit();
        }

        try {
            $datos = array();
            $datos = $Usuarios->login1($nombre_usuario, md5($contrasenia));
            $res = mysqli_fetch_assoc($datos);
        } catch (Throwable $th) {
            header("Location:../login.php?op=1");
            exit();
        }
        //TODO:Control de si existe el registro en la base de datos
        try {
            if (is_array($res) and count($res) > 0) {
              
                    // $datos2 = $Accesos->Insertar(date("Y-m-d H:i:s"), $res["idUsuarios"], 'ingreso');

                    $_SESSION["idUsuarios"] = $res["idUsuarios"];
                    $_SESSION["Usuarios_Nombres"] = $res["Nombres"];
                   
                    $_SESSION["Usuario_IdRoles"] = $res["idRoles"];
                    $_SESSION["Rol"] = $res["Rol"];

                    if ($res["Rol"] == 'Control') {
                        header("Location:../views/control.php");
                    } else {
                        header("Location:../views/home.php");
                    }
                    exit();
               
            } else {
                header("Location:../login.php?op=1");
                exit();
            }
        } catch (Exception $th) {
            echo ($th->getMessage());
        }
        break;
}
