<?php
require_once './clases/HistorialOperacion.php';
require_once 'IApiUsable.php';

class HistorialOperacionApi extends HistorialOperacion{
    public static function CargarUno($id_empleado) {
        HistorialOperacion::InsertarHistorial($id_empleado);
    }
}