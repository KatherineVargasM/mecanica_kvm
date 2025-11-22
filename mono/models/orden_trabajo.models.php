<?php
require_once('../config/conexion.php');

class OrdenTrabajo
{

    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        
        $cadena = "SELECT s.id as idServicio, 
                          DATE(s.fecha_servicio) as fecha, 
                          CONCAT(v.marca, ' ', v.modelo) as vehiculo, 
                          u.nombre_usuario as usuario,
                          (SELECT COUNT(*) FROM orden_trabajo WHERE Servicio_Id = s.id) as cantidad_items
                   FROM servicios s
                   LEFT JOIN vehiculos v ON s.id_vehiculo = v.id
                   LEFT JOIN usuarios u ON s.id_usuario = u.id
                   ORDER BY s.fecha_servicio DESC";
                   
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($idServicio)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        

        $sqlCabecera = "SELECT * FROM servicios WHERE id = $idServicio";
        $resCabecera = mysqli_query($con, $sqlCabecera);
        $cabecera = mysqli_fetch_assoc($resCabecera);


        $sqlItems = "SELECT ot.Descripcion as descripcion, 
                            ot.TipoServicio_Id as tipo_servicio_id, 
                            ot.Usuario_Id as usuario_id, 
                            ot.fecha
                     FROM orden_trabajo ot 
                     WHERE ot.Servicio_Id = $idServicio";
        $resItems = mysqli_query($con, $sqlItems);
        
        $items = [];
        while($row = mysqli_fetch_assoc($resItems)) {
            $items[] = $row;
        }

        $con->close();
        return ["cabecera" => $cabecera, "items" => $items];
    }

    public function Insertar($id_vehiculo, $id_usuario, $fecha, $items)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $cadena = "INSERT INTO servicios (id_vehiculo, id_usuario, fecha_servicio) VALUES ($id_vehiculo, $id_usuario, '$fecha')";
        
        if (mysqli_query($con, $cadena)) {
            $idServicio = mysqli_insert_id($con);

            foreach ($items as $item) {
                $desc = $item['descripcion'];
                $tipo = $item['tipo_servicio_id'];
                $usu  = $item['usuario_id'];
                $fec  = $item['fecha'];
                
                $sqlItem = "INSERT INTO orden_trabajo (Descripcion, Servicio_Id, TipoServicio_Id, Usuario_Id, fecha) 
                            VALUES ('$desc', $idServicio, $tipo, $usu, '$fec')";
                mysqli_query($con, $sqlItem);
            }
            $con->close();
            return "ok";
        } else {
            $con->close();
            return "Error: " . mysqli_error($con);
        }
    }

    public function Actualizar($idServicio, $id_vehiculo, $id_usuario, $fecha, $items)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $cadena = "UPDATE servicios SET id_vehiculo=$id_vehiculo, id_usuario=$id_usuario, fecha_servicio='$fecha' WHERE id=$idServicio";
        
        if (mysqli_query($con, $cadena)) {
            mysqli_query($con, "DELETE FROM orden_trabajo WHERE Servicio_Id = $idServicio");

            foreach ($items as $item) {
                $desc = $item['descripcion'];
                $tipo = $item['tipo_servicio_id'];
                $usu  = $item['usuario_id'];
                $fec  = $item['fecha'];
                
                $sqlItem = "INSERT INTO orden_trabajo (Descripcion, Servicio_Id, TipoServicio_Id, Usuario_Id, fecha) 
                            VALUES ('$desc', $idServicio, $tipo, $usu, '$fec')";
                mysqli_query($con, $sqlItem);
            }
            $con->close();
            return "ok";
        } else {
            $con->close();
            return "Error: " . mysqli_error($con);
        }
    }

    public function Eliminar($idServicio)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        
        mysqli_query($con, "DELETE FROM orden_trabajo WHERE Servicio_Id = $idServicio");
        
        if (mysqli_query($con, "DELETE FROM servicios WHERE id = $idServicio")) {
            $con->close();
            return "ok";
        } else {
            $con->close();
            return "Error: " . mysqli_error($con);
        }
    }
}
?>