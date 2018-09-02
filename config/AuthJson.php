<?php

 include_once dirname(__FILE__)  . '/my_key.php';
 use Firebase\JWT\JWT;

 require_once dirname(__FILE__)  . '/php-jwt-master/src/JWT.php';

class Token
{
    private $id ;
    private $rol ;
    private $created_time ;
    private $expiration ;
    private $jwt_own = "null";

    public function __construct()
    {
    }

    public function encode_key($id, $rol)
    {
        $this->id = $id ;
        $this->rol = $rol ;
        $this->created_time = time();
        $this->expiration = $this->created_time + ((60*60) * 24 ) /*Un dia */ ;
        $key = MY_KEY;
        $token = array(
        'id' => $this->id,
        'rol' => $this->rol,
        'created' => $this->created_time,
        'expiration' => $this->expiration
      );
        $jwt = JWT::encode($token, $key);
        $this->jwt_own = $jwt ;
        return $jwt ;
    }

    public function decoding_key($jwt_in)
    {
        try {
            $key = MY_KEY;
            $this->jwt_own = $jwt_in ;
            $decoded = JWT::decode($this->jwt_own, $key, array('HS256'));
            if (!empty($decoded)) {

            $this->id = $decoded->id;

            $this->rol = $decoded->rol;
            $this->created_time = $decoded->created;
            $this->expiration = $decoded->expiration;
            return $decoded->rol ;
          }
        } catch (\Exception $e) {
            echo 'error' . $e;
        }
        return false ;
    }

    private static function is_valid($token)
    {
        $time = time();
        if (($time - $token->expiration) > 0) {
            return false ;
        }
        return true ;
    }

    public static function is_valid_user($token)
    {
      if (Token::is_valid($token)){
        if ($token->rol == "user"){
          return true ;
        }
      }
      return false ;
    }

    public static function is_valid_admin($token)
    {
      if (Token::is_valid($token)){
        if ($token->rol == "admin"){
          return true ;
        }
      }
      return false ;
    }
    /**
     * Get the value of Jwt Own
     *
     * @return mixed
     */
    public function getJwtOwn()
    {
        return $this->jwt_own;
    }
}
