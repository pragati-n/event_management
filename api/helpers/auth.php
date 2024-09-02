<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class auth
{
    private $jwtSecret;

    public function __construct()
    {
        
    }

    static public function createToken($userArr)
    {
       
        $payload = [
            'iss' => getenv('DB_HOST'),
            'iat' => time(),
            'exp' => time() + 3600, // Token expires in 1 hour
            'userId' => $userArr['u_id'],
            'userRole' =>  $userArr['role'],
        ];
        
     
        $jwtSecret = getenv('JWT_SECRET');
        return JWT::encode($payload, $jwtSecret,'HS256');
    }

    static public function verifyToken($token)
    {
        try 
        {
            $jwtSecret = getenv('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($jwtSecret, 'HS256'));
           // $decoded = JWT::decode($token, $this->jwtSecret, array('HS256'));
            return $decoded;
        } catch (Exception $e)
        {
            return null;
        }
    }
}
