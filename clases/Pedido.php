<?php

require_once 'Producto.php';

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
        $pedido= $consulta->fetchObject('Pedido');
        return $pedido;
    }

    public static function TraerUnPedidoProductoPorId($id){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select id from pedido_producto WHERE id=:id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();
        $pedido= $consulta->fetch();
        return $pedido;
    }

    public function InsertarUnPedido(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        do{
            $this->id = substr(md5(time()), rand(0, 26), 5);
        }while(Pedido::TraerUnPedidoPorId($this->id));
        $this->CalcularTotalYTiempoEstimado();
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedido (id, mesa, total, tiempo_final_estimado, estado)values(:id, :mesa, :total,:tiempo_final_estimado, :estado)");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_STR);
        $consulta->bindValue(':mesa', $this->mesa);
        $consulta->bindValue(':total', $this->total);

        $time = new DateTime(date("Y-m-d H:i:s"));
        $time->add(new DateInterval('PT' . $this->tiempo_final_estimado . 'M'));

        $consulta->bindValue(':tiempo_final_estimado', $time->format("Y-m-d H:i:s"));
        $consulta->bindValue(':estado', 1, PDO::PARAM_INT);
        $consulta->execute();
        foreach($this->productos as $producto){
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedido_producto (pedido_id, producto_id, cantidad, estado)values(:pedido_id, :producto_id, :cantidad, :estado)");
            $consulta->bindValue(':pedido_id', $this->id, PDO::PARAM_STR);
            $consulta->bindValue(':producto_id', $producto['producto'], PDO::PARAM_INT);
            $consulta->bindValue(':cantidad', $producto['cantidad'], PDO::PARAM_INT);
            $consulta->bindValue(':estado', 1, PDO::PARAM_INT);
            $consulta->execute();
        }
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE mesa SET estado=:estado WHERE id=:mesa");
        $consulta->bindValue(':estado', 2, PDO::PARAM_INT);
        $consulta->bindValue(':mesa', $this->mesa);
        $consulta->execute();
        return $this->id;
    }

    public static function TraerPedidosConEstados(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT p.id, p.mesa, e.estado FROM pedido as p INNER JOIN pedido_estado as e ON p.estado= e.id");
        $consulta->execute();
        $resultados= $consulta->fetchAll(PDO::FETCH_FUNC, "PedidoEstados");
        return $resultados;
    }

    private function CalcularTotalYTiempoEstimado(){
        foreach($this->productos as $producto){
            $this->total = 0;
            $this->tiempo_final_estimado = 0;
            $producto_bd = Producto::TraerUnProductoPorId($producto['producto']);
            $this->total += ($producto_bd->precio * $producto['cantidad']);
            $this->tiempo_final_estimado = max($this->tiempo_final_estimado, $producto_bd->tiempo_estimado);
        }
    }

    public static function TraerProductosPendientes($sector){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT p.pedido_id, p.cantidad, pr.nombre FROM pedido_producto as p INNER JOIN producto as pr ON p.producto_id=pr.id INNER JOIN sector as s ON pr.sector_id = s.id WHERE p.estado=:estado AND s.nombre=:sector");
        $consulta->bindValue(':estado', 1, PDO::PARAM_INT);
        $consulta->bindValue(':sector', $sector, PDO::PARAM_STR);
        $consulta->execute();
        $resultados= $consulta->fetchAll(PDO::FETCH_FUNC, "ProductosPendientes");
        return $resultados;
    }

    public static function PrepararUnProducto($pedido_producto){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE pedido_producto SET estado=:estado WHERE id=:id");
        $consulta->bindValue(':estado', 2, PDO::PARAM_INT);
        $consulta->bindValue(':id', $pedido_producto, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function PrepararUnPedido($pedido){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE pedido SET estado=:estado WHERE id=:id");
        $consulta->bindValue(':estado', 2, PDO::PARAM_INT);
        $consulta->bindValue(':id', $pedido, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function ServirUnProducto($pedido_producto){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE pedido_producto SET estado=:estado WHERE id=:id");
        $consulta->bindValue(':estado', 3, PDO::PARAM_INT);
        $consulta->bindValue(':id', $pedido_producto, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function TieneProductosParaServir($pedido){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT COUNT(*) FROM pedido_producto WHERE pedido_id=:pedido_id");
        $consulta->bindValue(':pedido_id', $pedido, PDO::PARAM_INT);
        $consulta->execute();
        $cantidad = $consulta->fetch();
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT COUNT(*) FROM pedido_producto WHERE pedido_id=:pedido_id AND estado=:estado");
        $consulta->bindValue(':pedido_id', $pedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', 3, PDO::PARAM_INT);
        $consulta->execute();
        $cantidadLista = $consulta->fetch();
        return $cantidad == $cantidadLista;
    }

    public static function ServirUnPedido($pedido){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE pedido SET estado=:estado WHERE id=:id");
        $consulta->bindValue(':estado', 3, PDO::PARAM_INT);
        $consulta->bindValue(':id', $pedido, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function EntregarUnPedido($pedido){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE pedido SET tiempo_entregado=:tiempo_entregado, estado=:estado WHERE id=:id");
        $consulta->bindValue(':estado', 4, PDO::PARAM_INT);

        $time = new DateTime(date("Y-m-d H:i:s"));

        $consulta->bindValue(':tiempo_entregado', $time->format("Y-m-d H:i:s"));
        $consulta->bindValue(':id', $pedido, PDO::PARAM_INT);
        $consulta->execute();

        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE mesa as m INNER JOIN pedido as p ON p.mesa = m.id SET m.estado=:estado WHERE p.id=:id");
        $consulta->bindValue(':estado', 3, PDO::PARAM_INT);
        $consulta->bindValue(':id', $pedido);
        $consulta->execute();
    }

    public static function PagarUnPedido($pedido){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE pedido SET estado=:estado WHERE id=:id");
        $consulta->bindValue(':estado', 5, PDO::PARAM_INT);
        $consulta->bindValue(':id', $pedido, PDO::PARAM_INT);
        $consulta->execute();

        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE mesa as m INNER JOIN pedido as p ON p.mesa = m.id SET m.estado=:estado WHERE p.id=:id");
        $consulta->bindValue(':estado', 4, PDO::PARAM_INT);
        $consulta->bindValue(':id', $pedido);
        $consulta->execute();
    }
}


function PedidoEstados($id, $mesa, $estado){
    return "{id: {$id} , mesa: {$mesa}, estado: {$estado}}";
}

function ProductosPendientes($id, $cantidad, $nombre){
    return "{id: {$id} , cantidad: {$cantidad}, nombre: {$nombre}}";
}