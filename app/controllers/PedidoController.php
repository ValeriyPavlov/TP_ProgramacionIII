<?php
require_once "./models/Pedido.php";
require_once "./models/Producto.php";
require_once "./models/Mesa.php";

class PedidoController extends Pedido
{
    public function CargarPedido($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $idProducto = Producto::GetProductoPorId($parametros['idProducto']);
        $cantidadProductos = $parametros['cantidadProductos'];
        $idMesa = Mesa::GetMesaPorId($parametros['idMesa']);
        $codigoPedido = $parametros['codigoPedido'];

        if($idProducto != null && $idMesa != null)
        {
            $pedido = new Pedido();
            $pedido->idEmpleado = 0;
            $pedido->idProducto = $parametros['idProducto'];
            $pedido->cantidadProductos = $cantidadProductos;
            $pedido->idMesa = $parametros['idMesa'];
            $pedido->estado = "Pendiente";
            $pedido->codigoPedido = $codigoPedido;
            $pedido->tiempoPreparacion = 0;
            $pedido->AltaPedido();
            $payload = json_encode(array("Mensaje" => "Pedido creado con exito"));
        }
        else
        {
            $payload = json_encode(array("Mensaje" => "El producto o la mesa no existen!"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function MostrarPedidos($request, $response, $args)
    {
        $lista = Pedido::GetPedidos();
        $payload = json_encode(array("Pedidos" => $lista));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

?>