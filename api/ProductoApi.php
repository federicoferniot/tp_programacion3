<?php
require_once './clases/Producto.php';
require_once 'IApiUsable.php';

class ProductoApi extends Producto implements IApiUsable{
    public static function CargarUno($request, $response) {
        $ArrayDeParametros = $request->getParsedBody();
        $nombre= $ArrayDeParametros['nombre'];
        $precio= $ArrayDeParametros['precio'];
        $sector_id= $ArrayDeParametros['sector_id'];
        $producto = new Sector();
        $producto->nombre=$nombre;
        $producto->precio=$precio;
        $producto->sector_id=$sector_id;

        $producto->InsertarUnProducto();
        
        $response->getBody()->write("se guardo el producto");
        return $response;
    }

    public function TraerUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $id= $args['id'];
        $sector=Sector::TraerUnProductoPorId($id);
        $newResponse = $response->withJson($sector, 200);  
        return $newResponse;
    }

    public function TraerTodos($request, $response, $args) {
        $todosLosProductos=Sector::TraerTodosLosProductos();
        $newResponse = $response->withJson($todosLosProductos, 200);  
        return $newResponse;
    }
}