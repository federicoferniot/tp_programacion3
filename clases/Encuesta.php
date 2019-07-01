<?php

class Encuesta{
    public $pMesa;
    public $pRestaurante;
    public $pMozo;
    public $pCocinero;
    public $comentario;

    public function InsertarUnaEncuesta(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into encuesta (pMesa, pRestaurante, pMozo, pCocinero, comentario)values(:pMesa, :pRestaurante, :pMozo,:pCocinero, :comentario)");
        $consulta->bindValue(':pMesa', $this->pMesa, PDO::PARAM_INT);
        $consulta->bindValue(':pRestaurante', $this->pRestaurante, PDO::PARAM_INT);
        $consulta->bindValue(':pMozo', $this->pMozo, PDO::PARAM_INT);
        $consulta->bindValue(':pCocinero', $this->pCocinero, PDO::PARAM_INT);
        $consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
}