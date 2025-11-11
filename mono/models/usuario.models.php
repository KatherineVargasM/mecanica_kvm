<?php
//TODO: Requerimientos 
require_once('../config/conexion.php');
require_once('../models/Usuarios_Roles.models.php');
class Usuarios
{
    /*TODO: Procedimiento para sacar todos los registros*/
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `usuarios` inner JOIN roles on usuarios.id_rol = roles.id";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    /*TODO: Procedimiento para sacar un registro*/
    public function uno($idUsuarios)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `usuarios` inner JOIN roles on usuarios.id_rol = roles.id where usuarios.id_rol =  $idUsuarios";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
   
    public function unoNombreUsuario($NombreUsuario) 
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `usuarios` WHERE `nombre_usuario`='$NombreUsuario'";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
   
    /*TODO: Procedimiento para insertar */
    public function Insertar($nombre_usuario, $contrasena, $id_rol, $fecha_creacion)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT into usuarios(nombre_usuario, contrasena, id_rol, fecha_creacion) values ( '$nombre_usuario', '$contrasena', $id_rol, '$fecha_creacion')";
        if (mysqli_query($con, $cadena)) {
            return 'ok';
        } else {
            return 'Error al insertar en la base de datos';
        }
        $con->close();
    }
   

    /*TODO: Procedimiento para actualizar */
    public function Actualizar($idUsuarios, $nombre_usuario, $contrasena, $id_rol, $fecha_creacion)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "update usuarios set nombre_usuario='$nombre_usuario', contrasena='$contrasena', id_rol=$id_rol, fecha_creacion='$fecha_creacion' where idUsuarios= $idUsuarios";
        if (mysqli_query($con, $cadena)) {

            return 'ok';
        } else {
            return 'error al actualizar el registro';
        }
        $con->close();
    }
    /*TODO: Procedimiento para Eliminar */
    public function Eliminar($idUsuarios)
    {
        $UsRoles = new Usuarios_Roles();
        $UsRoles->Eliminar($idUsuarios);
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM `usuarios` WHERE id = $idUsuarios";
        if (mysqli_query($con, $cadena)) {
            return 'ok';
        } else {
            return false;
        }
        $con->close();
    }

     public function login1($nombre_usuario, $contrasena){
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "select * from usuarios where nombre_usuario='$nombre_usuario' and contrasena='$contrasena'";
        $datos = mysqli_query($con,$cadena);
        $con->close();
        return $datos;
    }
    public function login2($nombre_usuario){
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "select * from usuarios where nombre_usuario='$nombre_usuario'";
        $datos = mysqli_query($con,$cadena);
        $con->close();
        return $datos;
    }
}
