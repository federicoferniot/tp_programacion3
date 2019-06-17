<?php

class Producto{
    public $id;
    public $nombre;
    public $precio;
    public $sector_id;

    public function InsertarUnProducto(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into producto (nombre, precio, sector_id)values(:nombre, :precio, :sector_id)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio);
        $consulta->bindValue(':sector_id', $this->sector_id, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerUnProductoPorId($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id as id, nombre as nombre, precio as precio, sector_id as sector_id from producto WHERE id=:id");
			$consulta->bindValue(':id', $id, PDO::PARAM_INT);
			$consulta->execute();
			$sectorBuscado= $consulta->fetchObject('Producto');
      		return $sectorBuscado;				
    }

    public static function TraerTodosLosProductos(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("elect id as id, nombre as nombre, precio as precio, sector_id as sector_id from producto");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");
    }
}