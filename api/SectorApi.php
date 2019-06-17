<?php
require_once './clases/Sector.php';
require_once 'IApiUsable.php';

class SectorApi extends Sector implements IApiUsable{
    public static function CargarUno($request, $response) {
        $ArrayDeParametros = $request->getParsedBody();
        $nombre= $ArrayDeParametros['nombre'];
        $sector = new Sector();
        $sector->nombre=$nombre;

        $sector->InsertarUnSector();
        
        $response->getBody()->write("se guardo el sector");
        return $response;
    }

    public function TraerUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $id= $args['id'];
        $sector=Sector::TraerUnSectorPorId($id);
        $newResponse = $response->withJson($sector, 200);  
        return $newResponse;
    }

    public function TraerTodos($request, $response, $args) {
        $todosLosSectores=Sector::TraerTodosLosSectores();
        $newResponse = $response->withJson($todosLosSectores, 200);  
        return $newResponse;
    }
}