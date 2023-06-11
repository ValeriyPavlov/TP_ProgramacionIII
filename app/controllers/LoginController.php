<?php
require_once "./models/AuthJWT.php";
require_once "./models/Empleado.php"; 

class LoginController extends AuthJWT //
{
    public function GenerarToken($request, $response)
    {
        $datosPost = $request->getParsedBody();
        $datosBD = Empleado::GetEmpleadoPorId($datosPost["id"]);

        $datos = array('id'=> $datosBD->id, 'nombre' => $datosBD->nombre, 'clave' => $datosBD->clave,"rol"=> $datosBD->rol);
        $token = AuthJWT::NuevoToken($datos);
        $payload = json_encode(array('Token' => $token));
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }
}



?>