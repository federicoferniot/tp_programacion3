<?php
require_once './clases/Mesa.php';
require_once 'IApiUsable.php';

class MesaApi extends Mesa implements IApiUsable{
    public static function CargarUno($request, $response){
        $mesa = new Mesa();
        $mesa->InsertarUnaMesa();

        $response->getBody()->write("se guardo la mesa");
        return $response;
    }

    public function TraerTodos($request, $response, $args) {
        $todasLasMesas=Mesa::TraerTodasLasMesas();
        $newResponse = $response->withJson($todasLasMesas, 200);  
        return $newResponse;
    }

    public function CerrarMesa($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $mesa = $ArrayDeParametros['mesa'];
        Mesa::CerrarUnaMesa($mesa);
        return $response->withJson(array("estado" => "Ok", "mensaje" => "Mesa cerrada"));
    }
}