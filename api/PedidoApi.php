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
        $pedido->InsertarUnPedido();
        
        //$response->getBody()->write("asd".$nombre[0]['producto']);
        $response->getBody()->write("Ok");
        return $response;
    }

    public function TraerTodos($request, $response, $args){
        return "ok";
    }
}