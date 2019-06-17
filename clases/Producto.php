<?php

class Producto{
    public $id;
    public $nombre;
    public $precio;
    public $tiempo_estimado;
    public $sector_id;

    public function InsertarUnProducto(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into producto (nombre, precio, tiempo_estimado, sector_id)values(:nombre, :precio, :tiempo_estimado, :sector_id)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':tiempo_estimado', $this->tiempo_estimado, PDO::PARAM_INT);
        $consulta->bindValue(':sector_id', $this->sector_id, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerUnProductoPorId($id){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select id as id, nombre as nombre, precio as precio, tiempo_estimado as tiempo_estimado, sector_id as sector_id from producto WHERE id=:id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $productoBuscado= $consulta->fetchObject('Producto');
        return $productoBuscado;				
    }

    public static function TraerTodosLosProductos(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select id as id, nombre as nombre, precio as precio, tiempo_estimado as tiempo_estimado,sector_id as sector_id from producto");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");
    }
}