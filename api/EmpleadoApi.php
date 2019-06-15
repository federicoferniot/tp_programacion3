<?php
require_once './clases/Empleado.php';
require_once 'IApiUsable.php';

class EmpleadoApi extends Empleado implements IApiUsable{
    public function TraerTodos($request, $response, $args) {
        $todosLosEmpleados=Empleado::TraerTodoLosEmpleados();
        $newResponse = $response->withJson($todosLosEmpleados, 200);  
        return $newResponse;
    }

    public function CargarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $nombre= $ArrayDeParametros['nombre'];
        $empleado = new Empleado();
        $empleado->nombre=$nombre;

        $empleado->InsertarEmpleado();
        
        $response->getBody()->write("se guardo el empleado");
        return $response;
    }
}