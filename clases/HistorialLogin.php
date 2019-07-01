<?php

class HistorialLogin{
    public $id;
    public $empleado_id;
    public $fecha;

    public static function InsertarHistorial($id){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into registro_login (empleado_id, fecha)values(:empleado_id, :fecha)");
        $consulta->bindValue(':empleado_id', $id, PDO::PARAM_INT);
        $time = new DateTime(date("Y-m-d H:i:s"));
        $consulta->bindValue(':fecha', $time->format("Y-m-d H:i:s"));
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

}