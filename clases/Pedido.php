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
            $this->id = substr(md5(time()), rand(0, 26), 5);
        }while(Pedido::TraerUnPedidoPorId($this->id));
        //$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedido (id, mesa, total, tiempo_final_estimado, estado)values(:id, :mesa, :tiempo_final_estimado, :estado)");
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedido (id)values(:id)");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_STR);
        //$consulta->bindValue(':mesa', $this->mesa);
        //$consulta->bindValue(':tiempo_final_estimado', $this->tiempo_final_estimado, PDO::PARAM_INT);
        //$consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->execute();
        foreach($this->productos as $producto){
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedido_producto (pedido_id, producto_id, cantidad)values(:pedido_id, :producto_id, :cantidad)");
            $consulta->bindValue(':pedido_id', $this->id, PDO::PARAM_STR);
            $consulta->bindValue(':producto_id', $producto['producto'], PDO::PARAM_INT);
            $consulta->bindValue(':cantidad', $producto['cantidad'], PDO::PARAM_INT);
            $consulta->execute();
        }
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
}