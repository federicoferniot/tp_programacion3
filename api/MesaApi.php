<?php
require_once './clases/Mesa.php';
require_once 'IApiUsable.php';

class MesaApi extends Mesa implements IApiUsable{
    public function TraerTodos($request, $response, $args) {
        $todasLasMesas=Mesa::TraerTodasLasMesas();
        $newResponse = $response->withJson($todasLasMesas, 200);  
        return $newResponse;
    }
}