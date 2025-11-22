<?php

require_once('../config/conexion.php');

class Usuarios
{
    
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT usuarios.*, roles.id as IdRol, roles.nombre 
                   FROM `usuarios` 
                   INNER JOIN roles on usuarios.id_rol = roles.id 
                   WHERE usuarios.activo = 1";
                   
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }


    public function uno($idUsuarios)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        
        
        $cadena = "SELECT usuarios.*, roles.nombre 
                   FROM `usuarios` 
                   INNER JOIN roles on usuarios.id_rol = roles.id 
                   WHERE usuarios.id = $idUsuarios AND usuarios.activo = 1";
        
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
   
    public function unoNombreUsuario($NombreUsuario) 
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `usuarios` WHERE `nombre_usuario`='$NombreUsuario' AND activo = 1";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
   

    public function Insertar($nombre_usuario, $contrasena, $id_rol)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT into usuarios(nombre_usuario, contrasena, id_rol, fecha_creacion, activo) 
                   values ( '$nombre_usuario', '$contrasena', $id_rol, curdate(), 1)";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al insertar en la base de datos';
        }
    }
   


    public function Actualizar($idUsuarios, $nombre_usuario, $contrasena, $id_rol)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        
        $cadena = "UPDATE usuarios SET 
                   nombre_usuario='$nombre_usuario', 
                   contrasena='$contrasena', 
                   id_rol=$id_rol, 
                   fecha_creacion=curdate() 
                   WHERE id = $idUsuarios";
      
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'error al actualizar el registro';
        }
    }


    public function Eliminar($idUsuarios)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM `usuarios` WHERE id = $idUsuarios";
      
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return false;
        }
    }


    public function Eliminarsuave($idUsuarios)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE `usuarios` SET `activo`=0 WHERE id = $idUsuarios";
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return false;
        }
    }


     public function login1($nombre_usuario, $contrasena){
        try{
            $con = new ClaseConectar();
            $con = $con->ProcedimientoConectar();
            $cadena = "SELECT * FROM usuarios WHERE nombre_usuario='$nombre_usuario' AND contrasena='$contrasena'";
            $datos = mysqli_query($con,$cadena);
            $con->close();
            return $datos;
        }
        catch(Throwable $th){
            echo 'Error en el try ' . $th->getMessage();
        }
    }

    public function login2($nombre_usuario){
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT usuarios.id AS usuario_id, usuarios.nombre_usuario, usuarios.contrasena, usuarios.id_rol, roles.nombre AS rol_nombre, roles.descripcion AS rol_descripcion 
                   FROM usuarios 
                   INNER JOIN roles ON usuarios.id_rol = roles.id 
                   WHERE usuarios.nombre_usuario='$nombre_usuario' LIMIT 1";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function login($nombre_usuario, $contrasenia)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT usuarios.id AS usuario_id, usuarios.nombre_usuario, usuarios.contrasena, usuarios.id_rol, roles.nombre AS rol_nombre, roles.descripcion AS rol_descripcion 
                   FROM usuarios 
                   INNER JOIN roles ON usuarios.id_rol = roles.id 
                   WHERE usuarios.nombre_usuario='$nombre_usuario' LIMIT 1";
        $datos = mysqli_query($con, $cadena);
        $fila = mysqli_fetch_assoc($datos);
        $con->close();
        return $fila; 
    }
}