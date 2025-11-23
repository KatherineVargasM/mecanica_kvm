<?php

require_once('../config/conexion.php');
class TipoAcceso
{

    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `Tipo_Acceso`";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }

    public function uno($IdTipoAcceso)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `Tipo_Acceso` WHERE `IdTipoAcceso`=$IdTipoAcceso";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }

    public function Insertar($Detalle)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT INTO `Tipo_Acceso`(`Detalle`) VALUES ('$Detalle') ";

        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return mysqli_error($con);
        }
        $con->close();
    }

    public function Actualizar($IdTipoAcceso, $Detalle)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE `Tipo_Acceso` SET `Detalle`='$Detalle' WHERE `IdTipoAcceso`=$IdTipoAcceso";
        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return 'error al actualizar el registro';
        }
        $con->close();
    }

    public function Eliminar($IdTipoAcceso)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "delete from Tipo_Acceso where IdTipoAcceso = $IdTipoAcceso";

        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return false;
        }
        $con->close();
    }
}
