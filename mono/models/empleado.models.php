<?php
require_once('../config/conexion.php');

class Empleados
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM empleados WHERE estado = 1 ORDER BY apellidos ASC";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($id)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM empleados WHERE id = $id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function Insertar($cedula, $nombres, $apellidos, $correo, $telefono, $cargo)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT INTO empleados (cedula, nombres, apellidos, correo, telefono, cargo, estado) 
                   VALUES ('$cedula', '$nombres', '$apellidos', '$correo', '$telefono', '$cargo', 1)";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al insertar: ' . mysqli_error($con);
        }
    }

    public function Actualizar($id, $cedula, $nombres, $apellidos, $correo, $telefono, $cargo)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE empleados SET 
                   cedula='$cedula', 
                   nombres='$nombres', 
                   apellidos='$apellidos', 
                   correo='$correo', 
                   telefono='$telefono', 
                   cargo='$cargo' 
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
        $cadena = "DELETE FROM empleados WHERE id = $id";
        if (mysqli_query($con, $cadena)) return 'ok';
        else return 'Error al eliminar: ' . mysqli_error($con);
    }

    public function EliminarSuave($id)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE empleados SET estado = 0 WHERE id = $id";
        if (mysqli_query($con, $cadena)) return 'ok';
        else return 'Error al desactivar: ' . mysqli_error($con);
    }
}
?>