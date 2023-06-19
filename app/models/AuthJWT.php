<?php

use Firebase\JWT\JWT;

class AuthJWT
{
    private static $miClaveSecreta = "Progra3"; //Clave Secreta
    private static $algoritmoDeCodificacion = ['HS256']; // Algoritmo de Codificacion
    private static $aud = null;

    public static function NuevoToken($data)
    {
        $ahora = time();
        $payload = array(
            'iat' => $ahora,
            'exp' => $ahora + 2592000, // 1 mes
            'aud' => self::Aud(),
            'data' => $data
        );
        return JWT::encode($payload, self::$miClaveSecreta);
    }

    public static function ValidarToken($token)
    {
        if($token == "" || empty($token))
        {
            throw new Exception("El token esta vacio!");
        }

        try
        {
            $data = JWT::decode($token, self::$miClaveSecreta, self::$algoritmoDeCodificacion);
        }
        catch (Exception $excepcion)
        {
            throw new Exception("Usuario no valido.");
        }

        if($data->aud !== self::Aud())
        {
            throw new Exception("Usuario o contraseña no validos!");
        }
    }

    private static function Aud()
    {
        $aud = '';
        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
        {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } 
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
        {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } 
        else 
        {
            $aud = $_SERVER['REMOTE_ADDR'];
        }
        
        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();
        
        return sha1($aud);
    }

    public static function ObtenerPayLoad($token)
    {
        return JWT::decode(
            $token,
            self::$miClaveSecreta,
            self::$algoritmoDeCodificacion
        );
    }
    
    public static function ObtenerData($token)
    {
        return JWT::decode(
            $token,
            self::$miClaveSecreta,
            self::$algoritmoDeCodificacion
        )->data;
    }
}

?>