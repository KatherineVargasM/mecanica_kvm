<?php
require_once('../config/conexion.php');

class Clientes
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM clientes ORDER BY nombres ASC";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($id)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM clientes WHERE id = $id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function Insertar($nombres, $apellidos, $telefono, $correo)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT INTO clientes (nombres, apellidos, telefono, correo_electronico) 
                   VALUES ('$nombres', '$apellidos', '$telefono', '$correo')";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al insertar: ' . mysqli_error($con);
        }
    }

    public function Actualizar($id, $nombres, $apellidos, $telefono, $correo)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE clientes SET 
                   nombres='$nombres', 
                   apellidos='$apellidos', 
                   telefono='$telefono', 
                   correo_electronico='$correo' 
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
        $cadena = "DELETE FROM clientes WHERE id = $id";
        
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