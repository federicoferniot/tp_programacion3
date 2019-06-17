<?php

class Pedido{
    public $id;
    public $mesa;
    public $productos;
    public $total;
    public $tiempo_final_estimado;
    public $tiempo_entregado;
    public $estado;

    public static function TraerUnPedidoPorId($id){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select id as id, mesa as mesa, total as total, tiempo_final_estimado as tiempo_final_estimado, tiempo_entregado as tiempo_entregado, estado as estado from pedido WHERE id=:id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();
        $mesaBuscada= $consulta->fetchObject('Pedido');
        return $mesaBuscada;
    }

    public function InsertarUnPedido(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        do{
            $id = substr(md5(time(), 0, 5));
        }while(Mesa::TraerUnPedidoPorId($id));
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedido (id, mesa, total, tiempo_final_estimado, estado)values(:id, :mesa, :tiempo_final_estimado, :estado)");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->bindValue(':mesa', $this->mesa);
        $consulta->bindValue(':tiempo_final_estimado', $this->tiempo_final_estimado, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
}