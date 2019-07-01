<?php
require_once './clases/HistorialLogin.php';
require_once 'IApiUsable.php';

class HistorialLoginApi extends HistorialLogin{
    public static function CargarUno($id_empleado) {
        HistorialLogin::InsertarHistorial($id_empleado);
    }
}