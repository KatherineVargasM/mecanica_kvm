<?php
class ClaseConectar
{
    public $conexion;
    protected $db;
    private $host = "localhost";
    private $usu = "root";
    private $clave = ""; 
    private $base = "mecanica"; 

    public function ProcedimientoConectar()
    {

        $this->conexion = mysqli_connect($this->host, $this->usu, $this->clave, $this->base);
        
        if (!$this->conexion) {
            die("Error fatal de conexión: " . mysqli_connect_error());
        }


        mysqli_query($this->conexion, "SET NAMES utf8");

        $this->db = mysqli_select_db($this->conexion, $this->base);
       
        if (!$this->db) {
            die("Error: No se encuentra la base de datos '" . $this->base . "'. Phpmyadmin.");
        }
       
        return $this->conexion;
    }

    public function ruta()
    {
        define('BASE_PATH', realpath(dirname(__FILE__) . '/../') . '/');
    }
}
?>