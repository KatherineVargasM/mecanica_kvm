<?php
require_once('../config/conexion.php');

class Vehiculos
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM vehiculos";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
}
?>