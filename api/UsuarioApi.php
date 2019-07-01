<?php
require_once './clases/Usuario.php';
require_once './clases/Empleado.php';

class UsuarioApi extends Usuario{
    public static function CargarUno($request, $response) {
        $ArrayDeParametros = $request->getParsedBody();
        $username= $ArrayDeParametros['usuario'];
        $password= $ArrayDeParametros['password'];
        $usuario = new Usuario();
        $usuario->username=$username;
        $usuario->password=$password;

        $usuario->InsertarUsuario();
        
        $response->getBody()->write("se guardo el usuario");
        return $response;
    }

    public function TraerUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $username= $args['usuario'];
        $usuario=Usuario::TraerUnUsuario($username);
        $newResponse = $response->withJson($usuario, 200);  
        return $newResponse;
    }

    public function Login($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $usuario = Usuario::TraerUnUsuario($ArrayDeParametros['usuario']);
        if(hash('sha512', $ArrayDeParametros['password'].$ArrayDeParametros['usuario']) == $usuario->password){
            $empleado = Empleado::TraerUnEmpleadoPorIdUsuario($usuario->id);
            if($empleado){
                $token = AutentificadorJWT::CrearToken($empleado->id, $empleado->sector);
                return $response->withJson(array("estado" => "Ok", "token" => $token));
            }
            return $response->withJson(array("estado" => "Error", "mensaje" => 'No hay empleado '.$usuario->id));
        }
        return $response->withJson(array("estado" => "Error", "mensaje" => 'Contraseña incorrecta'));
    }
}