<?php

class Pedido
{
    public $id;
    public $idEmpleado;
    public $idProducto;
    public $cantidadProductos;
    public $idMesa;
    public $estado;
    public $codigoPedido;
    public $tiempoPreparacion;
    public $horaFinalizacion;

    public function AltaPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (idEmpleado, idProducto, cantidadProductos, idMesa, estado, codigoPedido, tiempoPreparacion) VALUES (:idEmpleado, :idProducto, :cantidadProductos, :idMesa, :estado, :codigoPedido, :tiempoPreparacion)");
        $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_INT);
        $consulta->bindValue(':idProducto', $this->idProducto, PDO::PARAM_INT);
        $consulta->bindValue(':cantidadProductos', $this->cantidadProductos, PDO::PARAM_INT);
        $consulta->bindValue(':idMesa', $this->idMesa, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado);
        $consulta->bindValue(':codigoPedido', $this->codigoPedido);
        $consulta->bindValue(':tiempoPreparacion', $this->tiempoPreparacion, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function GetPedidos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }
}

?>