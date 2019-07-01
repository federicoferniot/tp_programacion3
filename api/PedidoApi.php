<?php
require_once './clases/Pedido.php';
require_once './clases/Mesa.php';
require_once 'IApiUsable.php';

class PedidoApi extends Pedido implements IApiUsable{
    public static $destino = "./fotos/";

    public static function CargarUno($request, $response) {
        $ArrayDeParametros = $request->getParsedBody();
        $productos= json_decode($ArrayDeParametros['productos'], true);
        $mesa = $ArrayDeParametros['mesa'];

        $pedido = new Pedido();
        $pedido->productos = $productos;
        $pedido->mesa = $mesa;
        $id = $pedido->InsertarUnPedido();
        
        if(isset($ArrayDeParametros['foto'])){
            $uploadedFiles = $request->getUploadedFiles();
            $uploadedFile = $uploadedFiles['foto'];
            $array_nombre_archivo = explode(".", $uploadedFile->getClientFileName());

            $nombre_archivo = ($id).".";
            $nombre_archivo .= $array_nombre_archivo[sizeof($array_nombre_archivo)-1];
    
            $uploadedFile->moveTo(PedidoApi::$destino.$nombre_archivo);
        }

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
        $token= $request->getHeaderLine('token');
        $datos = AutentificadorJWT::ObtenerPayLoad($token);
        $estados = Pedido::TraerProductosPendientes($datos->sector);
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

    public static function TiempoRestante($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $pedido_id = $ArrayDeParametros['pedido'];
        $mesa_id = $ArrayDeParametros['mesa'];
        $mesa = Mesa::TraerUnaMesaPorId($mesa_id);
        $pedido = Pedido::TraerUnPedidoPorId($pedido_id);
        $tiempo_actual = new DateTime(date("Y-m-d H:i:s"));
        $intervalo = $tiempo_actual->diff($tiempo_actual);
        if($mesa && $pedido){
            $tiempo_estimado = new DateTime(date($pedido->tiempo_final_estimado));
            if($tiempo_actual < $tiempo_estimado){
                $intervalo = $tiempo_actual->diff($tiempo_estimado);
            }
        }
        return $response->withJson(array("estado" => "Ok", "mensaje" => "Tiempo restante: $intervalo->h:$intervalo->m:$intervalo->s"));
    }

    public static function EntregarPedido($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $pedido = $ArrayDeParametros['pedido'];
        Pedido::EntregarUnPedido($pedido);
        return $response->withJson(array("estado" => "Ok", "mensaje" => "Pedido entregado"));
    }

    public static function PagarPedido($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $pedido = $ArrayDeParametros['pedido'];
        Pedido::PagarUnPedido($pedido);
        return $response->withJson(array("estado" => "Ok", "mensaje" => "Pedido pagado"));
    }

    public static function ListarPedidos($request, $response, $args){
        $pedidos = Pedido::ListarTodosLosPedidos();
        return $response->withJson(array("estado" => "Ok", "mensaje" => $pedidos));
    }
}