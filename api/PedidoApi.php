<?php
require_once './clases/Pedido.php';
require_once 'IApiUsable.php';

class PedidoApi extends Pedido implements IApiUsable{
    public static function CargarUno($request, $response) {
        $ArrayDeParametros = $request->getParsedBody();
        $productos= json_decode($ArrayDeParametros['productos'], true);
        $mesa = $ArrayDeParametros['mesa'];

        $pedido = new Pedido();
        $pedido->productos = $productos;
        $pedido->mesa = $mesa;
        $id = $pedido->InsertarUnPedido();
        
        return $response->withJson(array("estado" => "Ok", "mensaje" => "Pedido dado de alta con Id: ".$id));
    }

    public function TraerTodos($request, $response, $args){
        return "ok";
    }

    public function VerEstados($request, $response, $args){
        $estados = Pedido::TraerPedidosConEstados();
        return $response->withJson(array("estado" => "Ok", "mensaje" => $estados));
    }

    public function ProductosPendientes($request, $response, $args){
        $estados = Pedido::TraerProductosPendientes(1);
        return $response->withJson(array("estado" => "Ok", "mensaje" => $estados));
    }

    public static function PrepararProducto($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $pedido_producto = $ArrayDeParametros['pedido_producto'];
        $pedido = $ArrayDeParametros['pedido'];
        if(Pedido::TraerUnPedidoProductoPorId($pedido_producto) && Pedido::TraerUnPedidoPorId($pedido)){
            Pedido::PrepararUnProducto($pedido_producto);
            Pedido::PrepararUnPedido($pedido);
            return $response->withJson(array("estado" => "Ok", "mensaje" => "Producto en preparación"));
        }
        return $response->withJson(array("estado" => "Error", "mensaje" => "No se encontró pedido"));
    }

    public static function ServirProducto($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $pedido_producto = $ArrayDeParametros['pedido_producto'];
        $pedido = $ArrayDeParametros['pedido'];
        if(Pedido::TraerUnPedidoProductoPorId($pedido_producto) && Pedido::TraerUnPedidoPorId($pedido)){
            Pedido::ServirUnProducto($pedido_producto);
            if(Pedido::TieneProductosParaServir($pedido)){
                Pedido::ServirUnPedido($pedido);
            }
            return $response->withJson(array("estado" => "Ok", "mensaje" => "Producto servido"));
        }
        return $response->withJson(array("estado" => "Error", "mensaje" => "No se encontró pedido"));
    }

    public static function EntregarPedido($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $pedido = $ArrayDeParametros['pedido'];
        Pedido::EntregarUnPedido($pedido);
        return $response->withJson(array("estado" => "Ok", "mensaje" => "Pedido entregado"));
    }
}