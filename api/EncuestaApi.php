<?php
require_once './clases/Encuesta.php';
require_once 'IApiUsable.php';

class EncuestaApi extends Encuesta{

    public static function CargarUno($request, $response) {
        $ArrayDeParametros = $request->getParsedBody();
        $encuesta = new Encuesta();
        $encuesta->pMesa =$ArrayDeParametros['pMesa'];
        $encuesta->pRestaurante=$ArrayDeParametros['pRestaurante'];
        $encuesta->pMozo=$ArrayDeParametros['pMozo'];
        $encuesta->pCocinero=$ArrayDeParametros['pCocinero'];
        $encuesta->comentario=$ArrayDeParametros['comentario'];
        $encuesta->InsertarUnaEncuesta();
        return $response->withJson(array("estado" => "Ok", "mensaje" => "Encuesta cargada"));
    }
}