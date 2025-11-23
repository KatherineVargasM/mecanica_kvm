<?php
require_once('../config/conexion.php');

class Reportes
{
    public function topClientes()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT c.nombres, c.apellidos, c.telefono, c.correo_electronico, 
                          COUNT(s.id) as total_visitas
                   FROM clientes c
                   INNER JOIN vehiculos v ON c.id = v.id_cliente
                   INNER JOIN servicios s ON v.id = s.id_vehiculo
                   GROUP BY c.id
                   ORDER BY total_visitas DESC";
                   
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
}
?>