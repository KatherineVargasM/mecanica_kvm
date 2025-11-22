<?php
error_reporting(0);

require_once('../config/sesiones.php');
require_once("../models/usuario.models.php");

$Usuarios = new Usuarios;

switch ($_GET["op"]) {

    case 'todos':
        $datos = array();
        $datos = $Usuarios->todos();
        $todos = array(); 
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

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
        $datos = $Usuarios->Insertar($NombreUsuario,  md5($Contrasenia),  $id_rol);
        echo json_encode($datos);
        break;

    case 'actualizar':
        $idUsuarios = $_POST["id"];
        $nombre_usuario = $_POST["NombreUsuario"];
        $contrasena = $_POST["contrasenia"];
        $id_rol = $_POST["id_rol"];
        $datos = array();
        $datos = $Usuarios->Actualizar($idUsuarios, $nombre_usuario, $contrasena, $id_rol);
        echo json_encode($datos);
        break;

    case 'eliminar':
        $idUsuarios = $_POST["idUsuarios"];
        $datos = array();
        $datos = $Usuarios->Eliminar($idUsuarios);
        echo json_encode($datos);
        break;
     case 'eliminarsuave':
        $idUsuarios = $_POST["idUsuarios"];
        $datos = array();
        $datos = $Usuarios->Eliminarsuave($idUsuarios);
        echo json_encode($datos);
        break;

    case 'login2':
        $nombre_usuario = isset($_POST['nombre_usuario']) ? trim($_POST['nombre_usuario']) : '';
        $contrasenia = isset($_POST['contrasenia']) ? trim($_POST['contrasenia']) : '';

        if ($nombre_usuario === '' || $contrasenia === '') {
            header("Location:../login.php?op=2");
            exit();
        }

        $fila = $Usuarios->login($nombre_usuario, md5($contrasenia));

        if (!$fila) {
            header("Location:../login.php?op=1"); 
            exit();
        }

        if (md5($contrasenia) !== $fila['contrasena']) {
            header("Location:../login.php?op=1"); 
            exit();
        }

        $_SESSION["idUsuarios"] = $fila["usuario_id"]; 
        $_SESSION["NombreUsuario"] = $fila["nombre_usuario"];
        $_SESSION["Rol"] = $fila["rol_nombre"]; 


        if ($_SESSION['Rol'] === 'Control') {
            header("Location:../views/control.php");
        } elseif ($_SESSION['Rol'] === 'ADMINISTRADOR') {
            header("Location:../views/home.php");
        } else {
            header("Location:../views/home.php");
        }
        exit();
        break;
    case 'login1':   
        
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasenia = $_POST['contrasenia'];


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
        try {
            if (is_array($res) and count($res) > 0) {
                $_SESSION['Rol'] = 'ADMINISTRADOR';
                $_SESSION["idUsuarios"] = $res["id"];
                $_SESSION["NombreUsuario"] = $res["nombre_usuario"];
                header("Location:../views/home.php"); 
                exit();
         } else {
                header("Location:../login.php?op=1");
            exit();
            }
        } catch (Exception $th) {
            error_log($th->getMessage());
        }
        break;
}
