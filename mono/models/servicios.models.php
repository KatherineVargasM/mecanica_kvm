<?php

require_once('../config/conexion.php');

class Servicios
{

    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `servicios`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

  
    public function uno($idServicio)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `servicios` WHERE `id` = $idServicio";
        $datos = mysqli_query($con, $cadena);

        $con->close();
        return $datos;
    }

    public function Insertar($id_vehiculo, $id_usuario)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
            $cadena = "INSERT INTO `servicios`(id_vehiculo, id_usuario, fecha_servicio) 
                       VALUES ($id_vehiculo, $id_usuario, curdate())";

     if (mysqli_query($con, $cadena)) {
        $idGenerado = mysqli_insert_id($con);
        $con->close();
        return $idGenerado;
        } else {
            $con->close();
            return 0; 
        }
    }


    public function Actualizar($idServicio, $id_vehiculo, $id_usuario, $fecha_servicio)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $cadena = "UPDATE `servicios` 
                   SET `id_vehiculo` = $id_vehiculo,
                       `id_usuario` = $id_usuario,
                       `fecha_servicio` = 'curdate()'
                   WHERE `id` = $idServicio";

        if (mysqli_query($con, $cadena)) {
            $respuesta = 'ok';
        } else {
            $respuesta = 'Error al actualizar';
        }

   
        $con->close();
        return $respuesta;
    }


    public function Eliminar($idServicio)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM `servicios` WHERE `id` = $idServicio";

        if (mysqli_query($con, $cadena)) {
            $respuesta = 'ok';
        } else {
            $respuesta = false;
        }

        $con->close();
        return $respuesta;
    }
}
