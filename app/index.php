<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr7Middlewares\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';
require_once './db/AccesoDatos.php';
require_once './controllers/LoginController.php';
require_once './controllers/EmpleadoController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/FacturaController.php';
require_once './controllers/EncuestaController.php';
require_once './middlewares/MWToken.php';
require_once './middlewares/MWMozo.php';
require_once './middlewares/MWSocio.php';

// Carga el archivo .env con la configuracion de la BD.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->post('/altaEmpleado', \EmpleadoController::class . ':CargarEmpleado')->add(new MWSocio());
    $group->get('/listarEmpleados', \EmpleadoController::class . ':MostrarEmpleados');
    $group->delete('/', \EmpleadoController::class . ':BorrarUno')->add(new MWSocio());
    $group->put('/', \EmpleadoController::class . ':ModificarUno')->add(new MWSocio());
})->add(new MWToken());

$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->post('/altaProducto', \ProductoController::class . ':CargarProducto');
  $group->get('/listarProductos', \ProductoController::class . ':MostrarProductos');
  $group->get('/exportarCSV', \ProductoController::class . ':ExportarProductos')->add(new MWSocio());
  $group->post('/importarCSV', \ProductoController::class . ':ImportarProductos')->add(new MWSocio());
})->add(new MWToken());

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->post('/altaMesa', \MesaController::class . ':CargarMesa');
  $group->get('/listarMesas', \MesaController::class . ':MostrarMesas')->add(new MWSocio());
  $group->put('/cambiarEstado', \MesaController::class . ':CambiarEstadoMesa')->add(new MWMozo());
  $group->delete('/cerrarMesa', \MesaController::class . ':CerrarMesa')->add(new MWSocio());
  $group->put('/abrirMesa', \MesaController::class . ':AbrirMesa')->add(new MWMozo());
})->add(new MWToken());

$app->group('/pedidos', function (RouteCollectorProxy $group) { 
  $group->post('/altaPedido', \PedidoController::class . ':CargarPedido')->add(new MWMozo());
  $group->get('/listarPedidos', \PedidoController::class . ':MostrarPedidos')->add(new MWSocio());
  $group->get('/MostrarPedidosEmpleado', \PedidoController::class . ':MostrarPedidosEmpleado');
  $group->get('/MostrarPedidosPreparados', \PedidoController::class . ':MostrarPedidosPreparados');
  $group->put('/prepararPedido', \PedidoController::class . ':PrepararPedido');
  $group->put('/PedidoListo', \PedidoController::class . ':CambiarEstadoListo');
  $group->get('/ConsultarPedidosListos', \PedidoController::class . ':ConsultarPedidosListos')->add(new MWMozo());
  $group->get('/MesaPopular',  \PedidoController::class . ':ConsultarMesaPopular')->add(new MWSocio());
})->add(new MWToken());

$app->get('/MejoresEncuestas', \EncuestaController::class . ':MostrarMejores')->add(new MWSocio());
$app->post('/Encuesta', \EncuestaController::class . ':CargarEncuesta');
$app->post('/Facturar', \FacturaController::class . ':CargarFactura')->add(new MWMozo());
$app->get('/MostrarFacturas', \FacturaController::class . ':MostrarFacturas');
$app->post('/demoraPedido', \PedidoController::class . ':ConsultarDemoraPedido');
$app->post('/login', \LoginController::class . ':GenerarToken');
$app->get('/login', \LoginController::class . ':Deslogear');

$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("TP Programacion III");
    return $response;
});

$app->run();

// php -S localhost:666 -t app