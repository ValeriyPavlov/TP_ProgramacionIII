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

// Load ENV
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
    $group->post('[/altaEmpleado]', \EmpleadoController::class . ':CargarEmpleado');
    $group->get('[/listarEmpleados]', \EmpleadoController::class . ':MostrarEmpleados');
  });

$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->post('[/altaProducto]', \ProductoController::class . ':CargarProducto');
  $group->get('[/listarProductos]', \ProductoController::class . ':MostrarProductos');
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->post('[/altaMesa]', \MesaController::class . ':CargarMesa');
  $group->get('[/listarMesas]', \MesaController::class . ':MostrarMesas');
});

$app->group('/pedidos', function (RouteCollectorProxy $group) { 
  $group->post('[/altaPedido]', \PedidoController::class . ':CargarPedido');  // Falta implementar validaciones y relaciones
  $group->get('[/listarPedidos]', \PedidoController::class . ':MostrarPedidos');
});

$app->post('/login', \LoginController::class . ':GenerarToken'); // Falta implementacion JWT

$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("TP Programacion III");
    return $response;
});

$app->run();
