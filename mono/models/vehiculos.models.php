<?php
require_once('../config/conexion.php');

class Vehiculos
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT v.*, c.nombres, c.apellidos 
                   FROM vehiculos v 
                   INNER JOIN clientes c ON v.id_cliente = c.id 
                   ORDER BY v.marca ASC";
        
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($id)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM vehiculos WHERE id = $id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function Insertar($id_cliente, $marca, $modelo, $anio, $tipo_motor)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT INTO vehiculos (id_cliente, marca, modelo, anio, tipo_motor) 
                   VALUES ($id_cliente, '$marca', '$modelo', $anio, '$tipo_motor')";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al insertar: ' . mysqli_error($con);
        }
    }

    public function Actualizar($id, $id_cliente, $marca, $modelo, $anio, $tipo_motor)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE vehiculos SET 
                   id_cliente=$id_cliente, 
                   marca='$marca', 
                   modelo='$modelo', 
                   anio=$anio, 
                   tipo_motor='$tipo_motor' 
                   WHERE id=$id";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al actualizar: ' . mysqli_error($con);
        }
    }

    public function Eliminar($id)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM vehiculos WHERE id = $id";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al eliminar: ' . mysqli_error($con);
        }
    }
}
?>