<?php
require_once './vendor/autoload.php';
require_once './jwt/AutentificadorJWT.php';
require_once './clases/UsuarioApi.php';
require_once './clases/Usuario.php';

class MWValidaciones{
    public static function ValidarCredenciales($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['usuario']) && isset($ArrayDeParametros['password'])){
            $usuario = Usuario::TraerUnUsuario($ArrayDeParametros['usuario']);
            if(hash('sha512', $ArrayDeParametros['password'].$ArrayDeParametros['usuario']) == $usuario->password){
                return AutentificadorJWT::CrearToken($request);
            }
            $request->getBody()->write('Contraseña incorrecta');
        }
        return $request;
    }

    public static function ValidarToken($request, $response, $next){
        $datos = $request->getHeaderLine('token');
        try{
            AutentificadorJWT::VerificarToken($datos);
            return $next($request, $response);
        } catch(Exception $e){
            return $e->getMessage();
        }
        return $response;
    }

    public static function ValidarDatosEntradaEmpleado($request, $response, $next){
        $ArrayDeParametros = $request->getParsedBody();
        if(isset($ArrayDeParametros['nombre']) && isset($ArrayDeParametros['usuario']) && isset($ArrayDeParametros['password'])){
            UsuarioApi::cargarUno($request, $response);
            return $next($request, $response);
        }
        return $response;
    }
}