<?php

class Mesa{
    public $id;
    public $estado;

    public static function TraerTodasLasMesas(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select mesa.id as id, mesa_estado.estado as estado from mesa inner join mesa_estado on mesa.estado = mesa_estado.id");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");
    }

    public static function TraerUnaMesaPorId($id){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select id as id, estado as estado from mesa WHERE id=:id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();
        $mesaBuscada= $consulta->fetchObject('Mesa');
        return $mesaBuscada;
    }

    public function InsertarUnaMesa(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        do{
            $this->id = substr(md5(time()), rand(0, 26), 5);
        }while(Mesa::TraerUnaMesaPorId($this->id));
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into mesa (id, estado)values(:id, :estado)");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_STR);
        $consulta->bindValue(':estado', 1, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
}