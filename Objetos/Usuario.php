<?php
class Usuario
{
  private $id;
  private $user_name ;
  private $nombre;
  private $apellido;
  private $password ;
  private $email;
  private $rol;

  private $connection ;

  public function __construct($conn)
  {
    $this->connection = $conn;
    $this->rol = 'user' ;
  }

  public function Registrar_Usuario()
  {
    try {
      $this->password = htmlspecialchars(strip_tags($this->password));
      $password   = crypt($this->password);
      $this->password =  null ;
      $query = 'INSERT INTO ' . 'usuarios' . ' SET user_name = :user_name, password = :password, nombre = :nombre, apellido = :apellido, emailadd = :emailadd, rol = :rol';
      $sql = $this->connection->prepare($query);

      $this->user_name = htmlspecialchars(strip_tags($this->user_name));
      $this->nombre = htmlspecialchars(strip_tags($this->nombre));
      $this->apellido = htmlspecialchars(strip_tags($this->apellido));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->rol = htmlspecialchars(strip_tags($this->rol));

      $sql->bindParam(':user_name', $this->user_name);
      $sql->bindParam(':password', $password);
      $sql->bindParam(':nombre', $this->nombre);
      $sql->bindParam(':apellido', $this->apellido);
      $sql->bindParam(':emailadd', $this->email);
      $sql->bindParam(':rol', $this->rol);
      if ($sql->execute()) {
        return "exito";
      }
    } catch (PDOException $e) {
      return "error " .  $e->getMessage();
    }
    return "error";
  }

  public function Auth_Oth($user_input)
  {
    try {
      $query = 'SELECT id, rol, password FROM ' . 'usuarios' . ' WHERE user_name = :user_name LIMIT 0,1';
      $sql = $this->connection->prepare($query);
      $this->user_name = htmlspecialchars(strip_tags($this->user_name));
      $sql->bindParam(':user_name', $this->user_name);
      $sql->execute();
      $res = $sql->fetch(PDO::FETCH_ASSOC);

      if (!empty($res)) {
        $this->id = $res['id'];
        $this->rol = $res['rol'];
        $this->password = $res['password'] ;

        if (hash_equals($this->password, crypt($user_input, $this->password))) {
          return "success";
        }
      } else {
        return "error" ;
      }
    } catch (PDOException $e) {
      return "error" .  $e->getMessage();
    }
    return "error";
  }

  public static function getAllUsers($connx)
  {
    try {
      $query = 'SELECT * FROM ' . 'usuarios';
      $sql = $connx->prepare($query);
      $sql->execute();
      $n = $sql->rowCount();
      if ($n > 0) {
        $respuesta = array();
        $respuesta['usuarios'] = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
          extract($fila);
          $cat_item = array(
            'id' => $id,
            'user_name' => $user_name,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'emailadd' => $emailadd,
            'rol' => $rol);
            array_push($respuesta['usuarios'], $cat_item);
          }

          return array( 'band' => true , 'res' =>  $respuesta) ;
        } else {
          return array( 'band' => false , 'res' => 'nul') ;
        }
      } catch (PDOException $e) {
        return array( 'band' => false , 'res' => 'nul') ;
      }
      return array( 'band' => false , 'res' => 'nul') ;
    }

    private static function existuser($conn , $usr_id){
      $query = 'SELECT * FROM ' . 'usuarios' . ' WHERE id = :id LIMIT 0,1';
      $stmt = $conn->prepare($query);

      $usr_id = htmlspecialchars(strip_tags($usr_id));

      $stmt->bindParam(':id', $usr_id);

      try{
        if($stmt->execute()) {
          $n = $stmt->rowCount();
          if ($n > 0){
            return true;
          }else{
            return false ;
          }

        }else{
          return false ;
        }
      } catch (PDOException $e) {
        return false ;
      }

      return false;

    }

    public static function makeAdmin($conn , $usr_id){
      if (!Usuario::existuser($conn, $usr_id)){
        return false ;
      }
      $query = 'UPDATE ' . 'usuarios' . ' SET rol = :rol WHERE id = :id';
      $stmt = $conn->prepare($query);

      $usr_id = htmlspecialchars(strip_tags($usr_id));
      $rol = "admin";
      if (!is_numeric($usr_id)){
        return false ;
      }
      $stmt->bindParam(':id', $usr_id);
      $stmt->bindParam(':rol', $rol);
      try{
        if($stmt->execute()) {

          return true;

        }else{
          return false ;
        }
      } catch (PDOException $e) {
        return false ;
      }

      return false;

    }
    /* GETTERS Y SETTERS*/

    /**
    * Get the value of Id
    *
    * @return mixed
    */
    public function getId()
    {
      return $this->id;
    }

    /**
    * Set the value of Id
    *
    * @param mixed id
    *
    * @return self
    */
    public function setId($id)
    {
      $this->id = $id;

      return $this;
    }

    /**
    * Get the value of User Name
    *
    * @return mixed
    */
    public function getUserName()
    {
      return $this->user_name;
    }

    /**
    * Set the value of User Name
    *
    * @param mixed user_name
    *
    * @return self
    */
    public function setUserName($user_name)
    {
      $this->user_name = $user_name;

      return $this;
    }

    /**
    * Get the value of Nombre
    *
    * @return mixed
    */
    public function getNombre()
    {
      return $this->nombre;
    }

    /**
    * Set the value of Nombre
    *
    * @param mixed nombre
    *
    * @return self
    */
    public function setNombre($nombre)
    {
      $this->nombre = $nombre;

      return $this;
    }

    /**
    * Get the value of Apellido
    *
    * @return mixed
    */
    public function getApellido()
    {
      return $this->apellido;
    }

    /**
    * Set the value of Apellido
    *
    * @param mixed apellido
    *
    * @return self
    */
    public function setApellido($apellido)
    {
      $this->apellido = $apellido;

      return $this;
    }

    /**
    * Get the value of Password
    *
    * @return mixed
    */
    public function getPassword()
    {
      return $this->password;
    }

    /**
    * Set the value of Password
    *
    * @param mixed password
    *
    * @return self
    */
    public function setPassword($password)
    {
      $this->password = $password;

      return $this;
    }

    /**
    * Get the value of Email
    *
    * @return mixed
    */
    public function getEmail()
    {
      return $this->email;
    }

    /**
    * Set the value of Email
    *
    * @param mixed email
    *
    * @return self
    */
    public function setEmail($email)
    {
      $this->email = $email;

      return $this;
    }

    /**
    * Get the value of Rol
    *
    * @return mixed
    */
    public function getRol()
    {
      return $this->rol;
    }

    /**
    * Set the value of Rol
    *
    * @param mixed rol
    *
    * @return self
    */
    public function setRol($rol)
    {
      $this->rol = $rol;

      return $this;
    }

    /**
    * Get the value of Connection
    *
    * @return mixed
    */
    public function getConnection()
    {
      return $this->connection;
    }

    /**
    * Set the value of Connection
    *
    * @param mixed connection
    *
    * @return self
    */
    public function setConnection($connection)
    {
      $this->connection = $connection;

      return $this;
    }
    /* ------------------ */
  }
