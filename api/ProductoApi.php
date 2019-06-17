<?php
require_once './clases/Producto.php';
require_once 'IApiUsable.php';

class ProductoApi extends Producto implements IApiUsable{
    public static function CargarUno($request, $response) {
        $ArrayDeParametros = $request->getParsedBody();
        $nombre= $ArrayDeParametros['nombre'];
        $precio= $ArrayDeParametros['precio'];
        $tiempo_estimado= $ArrayDeParametros['tiempo_estimado'];
        $sector_id= $ArrayDeParametros['sector_id'];
        $producto = new Producto();
        $producto->nombre=$nombre;
        $producto->precio=$precio;
        $producto->tiempo_estimado=$tiempo_estimado;
        $producto->sector_id=$sector_id;

        $producto->InsertarUnProducto();
        
        $response->getBody()->write("se guardo el producto");
        return $response;
    }

    public function TraerUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $id= $args['id'];
        $sector=Producto::TraerUnProductoPorId($id);
        $newResponse = $response->withJson($sector, 200);  
        return $newResponse;
    }

    public function TraerTodos($request, $response, $args) {
        $todosLosProductos=Producto::TraerTodosLosProductos();
        $newResponse = $response->withJson($todosLosProductos, 200);  
        return $newResponse;
    }
}