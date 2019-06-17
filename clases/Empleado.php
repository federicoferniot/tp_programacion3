<?php

class Empleado{
    public $id;
    public $nombre;
    public $apellido;
    public $estado;
    public $sector;
    public $usuario;

    public static function TraerTodoLosEmpleados(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select id,nombre as nombre from empleado");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");
    }
    
    public function InsertarEmpleado(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into empleado (nombre, usuario_id)values(:nombre, :usuario_id)");
        $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':usuario_id', $objetoAccesoDato->RetornarUltimoIdInsertado(), PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
}