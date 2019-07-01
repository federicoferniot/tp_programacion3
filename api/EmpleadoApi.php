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
        $sector = $ArrayDeParametros['sector'];
        $empleado = new Empleado();
        $empleado->nombre=$nombre;
        $empleado->sector=$sector;

        $empleado->InsertarEmpleado();
        
        $response->getBody()->write("se guardo el empleado");
        return $response->withJson(array("estado" => "Ok", "mensaje" => "Se dió de alta el empleado"));
    }

    public function ListadoEmpleados($request, $response, $args){
        $listado = Empleado::ListarEmpleados();
        return $response->withJson(array("estado" => "Ok", "mensaje" => $listado));
    }

    public function SuspenderEmpleado($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $id= $ArrayDeParametros['id'];
        Empleado::SuspenderUnEmpleadoPorId($id);
        return $response->withJson(array("estado" => "Ok", "mensaje" => "Empleado suspendido"));
    }
}