<?php
require_once './vendor/autoload.php';
require_once './jwt/AutentificadorJWT.php';
require_once './api/UsuarioApi.php';
require_once './api/HistorialLoginApi.php';
require_once './api/HistorialOperacionApi.php';
require_once './clases/Usuario.php';

class MWValidaciones{
    public static function ValidarCredenciales($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['usuario']) && isset($ArrayDeParametros['password'])){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "Faltan datos"));
    }

    public static function ValidarToken($request, $response, $next){
        $datos = $request->getHeaderLine('token');
        try{
            AutentificadorJWT::VerificarToken($datos);
            return $next($request, $response);
        } catch(Exception $e){
            return $response->withJson(array("estado" => "error", "mensaje" => $e->getMessage()));
        }
        return $response;
    }

    public static function ValidarMozo($request, $response, $next){
        $token= $request->getHeaderLine('token');
        $datos = AutentificadorJWT::ObtenerPayLoad($token);
        if($datos->sector == "Atención a mesas"){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "No tiene permisos para esta acción"));
    }

    public static function ValidarSocio($request, $response, $next){
        $token= $request->getHeaderLine('token');
        $datos = AutentificadorJWT::ObtenerPayLoad($token);
        if($datos->sector == "Socios"){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "No tiene permisos para esta acción"));
    }

    public static function ValidarOtrosEmpleados($request, $response, $next){
        $token= $request->getHeaderLine('token');
        $datos = AutentificadorJWT::ObtenerPayLoad($token);
        if($datos->sector == "Bar" || $datos->sector == "Cocina" || $datos->sector == "Cervecería"){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "No tiene permisos para esta acción"));
    }

    public static function RegistrarLogin($request, $response, $next){
        $respuesta = $next($request, $response);
        $respuesta_decode = json_decode($respuesta->getBody());
        if($respuesta_decode->estado == "Ok"){
            $token = $respuesta_decode->token;
            $datos = AutentificadorJWT::ObtenerPayLoad($token);
            HistorialLoginApi::CargarUno($datos->id);
        }
        return $respuesta;
    }

    public static function RegistrarOperacion($request, $response, $next){
        $respuesta = $next($request, $response);
        $token= $request->getHeaderLine('token');
        $datos = AutentificadorJWT::ObtenerPayLoad($token);
        HistorialOperacionApi::CargarUno($datos->id);
        return $respuesta;
    }

    public static function ValidarDatosEntradaCargarEmpleado($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['nombre']) && isset($ArrayDeParametros['usuario']) && isset($ArrayDeParametros['password'])){
            $respuesta = UsuarioApi::cargarUno($request, $response);
            $respuesta_decode = json_decode($respuesta->getBody());
            if($respuesta_decode->estado == "Ok"){
                return $next($request, $response);
            }else{
                return $respuesta;
            }
        }
        return $response->withJson(array("estado" => "Error", "mensaje" => "Faltan datos"));
    }

    public static function ValidarEntradaEmpleado($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['id'])){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "Faltan datos"));
    }

    public static function ValidarDatosEntradaCargarSector($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['nombre'])){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "Faltan datos"));
    }
    public static function ValidarDatosEntradaCargarProducto($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['nombre']) && isset($ArrayDeParametros['precio']) && isset($ArrayDeParametros['tiempo_estimado']) && isset($ArrayDeParametros['sector_id'])){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "Faltan datos"));
    }

    public static function ValidarDatosEntradaCargarPedido($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['mesa']) && isset($ArrayDeParametros['productos'])){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "Faltan datos"));
    }

    public static function ValidarDatosEntradaProductoPedido($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['pedido_producto']) && isset($ArrayDeParametros['pedido'])){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "Faltan datos"));
    }

    public static function ValidarDatosEntradaPedido($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['pedido'])){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "Faltan datos"));
    }

    public static function ValidarDatosEntradaEncuesta($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['pMesa']) && isset($ArrayDeParametros['pRestaurante']) && isset($ArrayDeParametros['pMozo']) && isset($ArrayDeParametros['pCocinero']) && isset($ArrayDeParametros['comentario'])){
            return $next($request, $response);
        }
        return $response->withJson(array("estado" => "error", "mensaje" => "Faltan datos"));
    }

}