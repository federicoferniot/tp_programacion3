<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once './vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './api/EmpleadoApi.php';
require_once './api/UsuarioApi.php';
require_once './api/SectorApi.php';
require_once './api/ProductoApi.php';
require_once './api/MesaApi.php';
require_once './api/PedidoApi.php';
require_once './jwt/AutentificadorJWT.php';
require_once './mw/MWValidaciones.php';
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
/*
¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).
  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/
$app = new \Slim\App(["settings" => $config]);
/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/

$app->group('/login', function(){
  $this->post('[/]', \MWValidaciones::class . ':ValidarCredenciales');
});


$app->group('/empleado', function () {

  $this->get('[/]', \EmpleadoApi::class . ':traerTodos');
  $this->post('[/]', \EmpleadoApi::class . ':CargarUno')->add(\MWValidaciones::class . ':ValidarDatosEntradaEmpleado');
});

$app->group('/usuario', function(){
  $this->get('/{usuario}', \UsuarioApi::class . ':TraerUno');
});

$app->group('/sector', function(){
  $this->get('/[{id}]', \SectorApi::class . ':TraerUno');
  $this->post('[/]', \SectorApi::class . ':CargarUno');
  $this->get('', \SectorApi::class . ':TraerTodos');
});

$app->group('/producto', function(){
  $this->get('/[{id}]', \ProductoApi::class . ':TraerUno');
  $this->post('[/]', \ProductoApi::class . ':CargarUno');
  $this->get('', \ProductoApi::class . ':TraerTodos');
});

$app->group('/mesa', function(){
  $this->get('', \MesaApi::class . ':TraerTodos');
  $this->post('[/]', \MesaApi::class . ':CargarUno');
});

$app->group('/pedido', function(){
  $this->post('[/]', \PedidoApi::class . ':CargarUno');
});

$app->run();