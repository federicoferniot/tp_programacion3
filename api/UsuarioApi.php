<?php
require_once './clases/Usuario.php';

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
}