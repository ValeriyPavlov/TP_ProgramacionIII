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
    $group->post('/altaEmpleado', \EmpleadoController::class . ':CargarEmpleado');
    $group->get('/listarEmpleados', \EmpleadoController::class . ':MostrarEmpleados');
})->add(new MWToken());

$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->post('/altaProducto', \ProductoController::class . ':CargarProducto');
  $group->get('/listarProductos', \ProductoController::class . ':MostrarProductos');
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
  $group->put('/prepararPedido', \PedidoController::class . ':PrepararPedido');
  $group->put('/PedidoListo', \PedidoController::class . ':CambiarEstadoListo');
  $group->get('/ConsultarPedidosListos', \PedidoController::class . ':ConsultarPedidosListos')->add(new MWMozo());
})->add(new MWToken());

$app->post('/Facturar', \FacturaController::class . ':CargarFactura')->add(new MWMozo());
$app->post('/demoraPedido', \PedidoController::class . ':ConsultarDemoraPedido');
$app->post('/login', \LoginController::class . ':GenerarToken');
$app->get('/login', \LoginController::class . ':Deslogear');

$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("TP Programacion III");
    return $response;
});

$app->run();

// php -S localhost:666 -t app