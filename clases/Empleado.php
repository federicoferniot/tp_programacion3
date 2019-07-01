<?php

class Empleado{
    public $id;
    public $nombre;
    public $usuario_id;
    public $estado;
    public $sector;

    public static function TraerTodoLosEmpleados(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT e.id as id, e.nombre as nombre, e.usuario_id as usuario_id, ee.nombre as estado, s.nombre as sector from empleado as e INNER JOIN sector as s ON e.sector=s.id INNER JOIN empleado_estado as ee ON e.estado=ee.id");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");
    }

    public static function ListarEmpleados(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT e.nombre, MAX(l.fecha) ultimo_logueo,COUNT(o.empleado_id) cantidad_operaciones FROM empleado as e LEFT JOIN registro_operacion as o ON e.id = o.empleado_id LEFT JOIN registro_login as l ON e.id = l.empleado_id GROUP BY e.id");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_FUNC, "Listado");
    }
    
    public function InsertarEmpleado(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into empleado (nombre, usuario_id, estado, sector)values(:nombre, :usuario_id, :estado, :sector)");
        $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':usuario_id', $objetoAccesoDato->RetornarUltimoIdInsertado(), PDO::PARAM_INT);
        $consulta->bindValue(':estado', 1, PDO::PARAM_INT);
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerUnEmpleadoPorIdUsuario($id){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT e.id as id, e.nombre as nombre, e.usuario_id as usuario_id, e.estado as estado, s.nombre as sector FROM empleado as e INNER JOIN sector as s on e.sector=s.id WHERE e.usuario_id=:usuario_id");
        $consulta->bindValue(':usuario_id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject("Empleado");
    }

    public static function SuspenderUnEmpleadoPorId($id){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE empleado SET estado=:estado WHERE id=:id");
        $consulta->bindValue(':estado', 2, PDO::PARAM_INT);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }
}

function Listado($nombre, $ultimo_log, $cantidad_operaciones){
    return "{nombre: {$nombre} , ultimo_login: {$ultimo_log}, cantidad_operaciones: {$cantidad_operaciones}}";
}