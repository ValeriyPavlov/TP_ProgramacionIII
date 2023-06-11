<?php

use Firebase\JWT\JWT;

class AuthJWT
{
    private static $miClaveSecreta = "Progra3"; //Clave Secreta
    private static $algoritmoDeCodificacion = 'HS256'; // Algoritmo de Codificacion

    public static function NuevoToken($data)
    {
        $ahora = time();
        $payload = array(
            'iat' => $ahora,
            'exp' => $ahora + 2592000, // 1 mes
            'data' => $data
        );
        return JWT::encode($payload, self::$miClaveSecreta, self::$algoritmoDeCodificacion);
    }

    public static function ValidarToken($token)
    {
        try
        {
            $data = JWT::decode($token, self::$miClaveSecreta, self::$algoritmoDeCodificacion);
            //TODO
            var_dump($data);
        }
        catch (Exception $excepcion)
        {
            throw $excepcion;
        }
    }
}

?>