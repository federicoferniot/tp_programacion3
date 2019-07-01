<?php
require_once './clases/Encuesta.php';
require_once 'IApiUsable.php';

class EncuestaApi extends Encuesta{

    public static function CargarUno($request, $response) {
        $ArrayDeParametros = $request->getParsedBody();

        $pMesa =$ArrayDeParametros['pMesa'];
        $pRestaurante=$ArrayDeParametros['pRestaurante'];
        $pMozo=$ArrayDeParametros['pMozo'];
        $pCocinero=$ArrayDeParametros['pCocinero'];
        $comentario=$ArrayDeParametros['comentario'];

        if((int)$pMesa >= 0 && (int)$pMesa<=10 &&(int)$pRestaurante >= 0 && (int)$pRestaurante<=10 && (int)$pMozo >= 0 && (int)$pMozo<=10 && (int)$pCocinero >= 0 && (int)$pCocinero<=10
        && strlen($comentario)<=66){
            $encuesta = new Encuesta();

            $encuesta->pMesa =$pMesa;
            $encuesta->pRestaurante=$pRestaurante;
            $encuesta->pMozo=$pMozo;
            $encuesta->pCocinero=$pCocinero;
            $encuesta->comentario=$comentario;
            $encuesta->InsertarUnaEncuesta();
            return $response->withJson(array("estado" => "Ok", "mensaje" => "Encuesta cargada"));
        }
        return $response->withJson(array("estado" => "Error", "mensaje" => "Hubo un error en los datos"));
    }
}