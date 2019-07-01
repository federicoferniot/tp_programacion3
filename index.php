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
require_once './api/EncuestaApi.php';
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

date_default_timezone_set("America/Argentina/Buenos_Aires");

$app = new \Slim\App(["settings" => $config]);
/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/

$app->group('/login', function(){
  $this->post('[/]', \UsuarioApi::class . ':login')->add(\MWValidaciones::class . ':RegistrarLogin')->add(\MWValidaciones::class . ':ValidarCredenciales');
});

$app->group('/empleado', function () {
  $this->get('[/]', \EmpleadoApi::class . ':traerTodos');
  $this->post('[/]', \EmpleadoApi::class . ':CargarUno')->add(\MWValidaciones::class . ':ValidarDatosEntradaCargarEmpleado');
  $this->post('/suspenderEmpleado', \EmpleadoApi::class . ':SuspenderEmpleado')->add(\MWValidaciones::class . ':ValidarEntradaEmpleado');
})->add(\MWValidaciones::class . ':ValidarSocio')->add(\MWValidaciones::class . ':ValidarToken');

$app->group('/usuario', function(){
  $this->get('/{usuario}', \UsuarioApi::class . ':TraerUno');
})->add(\MWValidaciones::class . ':ValidarSocio')->add(\MWValidaciones::class . ':ValidarToken');

$app->group('/sector', function(){
  $this->get('/{id}', \SectorApi::class . ':TraerUno');
  $this->post('[/]', \SectorApi::class . ':CargarUno')->add(\MWValidaciones::class . ':ValidarDatosEntradaCargarSector');
  $this->get('', \SectorApi::class . ':TraerTodos');
})->add(\MWValidaciones::class . ':ValidarSocio')->add(\MWValidaciones::class . ':ValidarToken');

$app->group('/producto', function(){
  $this->get('/{id}', \ProductoApi::class . ':TraerUno');
  $this->post('[/]', \ProductoApi::class . ':CargarUno')->add(\MWValidaciones::class . ':ValidarDatosEntradaCargarProducto');
  $this->get('', \ProductoApi::class . ':TraerTodos');
})->add(\MWValidaciones::class . ':ValidarSocio')->add(\MWValidaciones::class . ':ValidarToken');

$app->group('/mesa', function(){
  $this->get('', \MesaApi::class . ':TraerTodos');
  $this->post('[/]', \MesaApi::class . ':CargarUno');
  $this->post('/cerrarMesa', \MesaApi::class . ':CerrarMesa');
})->add(\MWValidaciones::class . ':ValidarSocio')->add(\MWValidaciones::class . ':ValidarToken');

$app->group('/pedido', function(){
  $this->post('[/]', \PedidoApi::class . ':CargarUno')->add(\MWValidaciones::class . ':ValidarDatosEntradaCargarPedido')->add(\MWValidaciones::class . ':RegistrarOperacion')->add(\MWValidaciones::class . ':ValidarMozo');
  $this->get('/verEstados', \PedidoApi::class . ':VerEstados')->add(\MWValidaciones::class . ':ValidarSocio');
  $this->get('/productosPendientes', \PedidoApi::class . ':ProductosPendientes')->add(\MWValidaciones::class . ':ValidarOtrosEmpleados');
  $this->post('/prepararPedido', \PedidoApi::class . ':PrepararProducto')->add(\MWValidaciones::class . ':ValidarDatosEntradaProductoPedido')->add(\MWValidaciones::class . ':RegistrarOperacion')->add(\MWValidaciones::class . ':ValidarOtrosEmpleados');
  $this->post('/servirProducto', \PedidoApi::class . ':ServirProducto')->add(\MWValidaciones::class . ':ValidarDatosEntradaProductoPedido')->add(\MWValidaciones::class . ':RegistrarOperacion')->add(\MWValidaciones::class . ':ValidarOtrosEmpleados');
  $this->post('/entregarPedido', \PedidoApi::class . ':EntregarPedido')->add(\MWValidaciones::class . ':ValidarDatosEntradaPedido')->add(\MWValidaciones::class . ':RegistrarOperacion')->add(\MWValidaciones::class . ':ValidarMozo');
  $this->post('/pagarPedido', \PedidoApi::class . ':PagarPedido')->add(\MWValidaciones::class . ':ValidarDatosEntradaPedido')->add(\MWValidaciones::class . ':RegistrarOperacion')->add(\MWValidaciones::class . ':ValidarMozo');
})->add(\MWValidaciones::class . ':ValidarToken');

$app->group('/cliente', function(){
  $this->post('/tiempoRestante', \PedidoApi::class . ':TiempoRestante');
  $this->post('/cargarEncuesta', \EncuestaApi::class . ':CargarUno')->add(\MWValidaciones::class . ':ValidarDatosEntradaEncuesta');
});

$app->group('/listado', function(){
  $this->get('/empleados', \EmpleadoApi::class . ':ListadoEmpleados');
  $this->get('/pedidos', \PedidoApi::class . ':ListarPedidos');
})->add(\MWValidaciones::class . ':ValidarSocio')->add(\MWValidaciones::class . ':ValidarToken');

$app->run();