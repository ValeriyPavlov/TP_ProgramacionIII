<?php
require_once "./models/Mesa.php";

class MesaController extends Mesa
{
    public static $estados = array("con cliente esperando pedido", "con cliente comiendo", "con cliente pagando", "cerrada");
    public function CargarMesa($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $estado = $parametros['estado'];

        if(in_array($estado, $this::$estados))
        {
            $producto = new Mesa();
            $producto->estado = $estado;
            $producto->AltaMesa();
            $payload = json_encode(array("Mensaje" => "Mesa creado con exito"));
        }
        else
        {
            $payload = json_encode(array("Mensaje" => "Estado de mesa no valido. (con cliente esperando pedido / con cliente comiendo / con cliente pagando / cerrada)"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function MostrarMesas($request, $response, $args)
    {
        $lista = Mesa::GetMesas();
        $payload = json_encode(array("Mesas" => $lista));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

?>