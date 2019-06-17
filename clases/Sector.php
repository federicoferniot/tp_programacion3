<?php

class Sector{
    public $id;
    public $nombre;

    public function InsertarUnSector(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into sector (nombre)values(:nombre)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerUnSectorPorId($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id as id, nombre as nombre from sector WHERE id=:id");
			$consulta->bindValue(':id', $id, PDO::PARAM_INT);
			$consulta->execute();
			$sectorBuscado= $consulta->fetchObject('Sector');
      		return $sectorBuscado;				
    }
    
    public static function TraerTodosLosSectores(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select id as id,nombre as nombre from sector");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Sector");
    }
}