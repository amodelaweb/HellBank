<?php
class TarjetaCredito
{
  private $id;
  private $idDueno;
  private $id_ahorros ;
  private $cupoMaximo;
  private $gastado ;
  private $sobreCupo;
  private $tasaInteres;
  private $mora ;
  private $cuotaManejo;
  private $fecha_ultimo_pago ;
  private $fecha_creado ;
  private $estado;
  private $connection ;

  public function __construct($conn)
  {
    $this->connection = $conn ;
  }
  public function create_tarjeta()
  {
    try {
      $query = 'INSERT INTO ' . 'tarjeta_credito' . ' SET id_dueno = :id_dueno, id_ahorros = :id_ahorros, cupo_maximo = :cupo_maximo, gastado = :gastado, sobre_cupo = :sobre_cupo, tasa_interes = :tasa_interes, mora = :mora, cuota_manejo = :cuota_manejo';
      $sql = $this->connection->prepare($query);
      $this->id_ahorros = htmlspecialchars(strip_tags($this->id_ahorros));
      $this->idDueno = htmlspecialchars(strip_tags($this->idDueno));
      $this->cupoMaximo = 0 ;
      $this->gastado =  0 ;
      $this->sobreCupo = 0 ;
      $this->tasaInteres = 0 ;
      $this->mora = 0 ;
      $this->fecha_creado = time() ;
      $this->cuotaManejo = 0 ;
      $sql->bindParam(':id_dueno', $this->idDueno);
      $sql->bindParam(':id_ahorros', $this->id_ahorros);
      $sql->bindParam(':cupo_maximo', $this->cupoMaximo);
      $sql->bindParam(':gastado', $this->gastado);
      $sql->bindParam(':sobre_cupo', $this->sobreCupo);
      $sql->bindParam(':tasa_interes', $this->tasaInteres);
      $sql->bindParam(':mora', $this->mora);
      $sql->bindParam(':cuota_manejo', $this->cuotaManejo);
      if ($sql->execute()) {
        return "exito";
      }
    } catch (PDOException $e) {
      return "error " .  $e->getMessage();
    }
    return "error";
  }
  /* GETTERS AND SETTERS */

  public function comprar($idTarjeta, $numCuotas, $mont, $tipoMoneda)
  {
    $dataBase = new Database();
    $con = $dataBase->connection();
    $sql1 = 'SELECT * FROM tarjeta_credito WHERE id = '.$idTarjeta;
    if(!empty($con->query($sql1))){
      foreach ($con->query($sql1) as $res1) {
        $cupo_maximo = $res1['cupo_maximo'];
        $gastado = $res1['gastado'];
        $sobre_cupo = $res1['sobre_cupo'];
        $id_dueno = $res1['id_dueno'];
        $estado = $res1['estado'];
      }
      if ($estado=="APROBADO") {
        $saldo = ($cupo_maximo+$sobre_cupo)-$gastado;
        if($saldo >= $mont){
          if ($tipoMoneda=="Pesos") {
            $mont=$mont/1000;
          }
          $gastado= $gastado+$mont;
          $sql2 = 'UPDATE tarjeta_credito SET gastado ='.$gastado.' WHERE id = '.$idTarjeta;
          $sql3 = 'INSERT INTO compra_credito (id_producto,monto,numero_cuotas,fecha_realizado) VALUES('.$idTarjeta.','.$mont.','.$numCuotas.',NOW())';
          $sql4 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$id_dueno.','.$id_dueno.',"Se ha hecho una compra por '.$mont.'")';
          $con->query($sql2);
          $con->query($sql3);
          $con->query($sql4);
          return array ( 'band' => true , 'msn' => "compra Realizada");
        }else{
          return array ( 'band' => false   , 'msn' => "No hay fondos suficientes");
        }
      }else{
        return array ( 'band' => false   , 'msn' => "Tarjeta de origen no existe");
      }
    }

  }

  public static function getUser_Tarjetas($id_user, $connx)
  {
    try {
      $query = 'SELECT * FROM ' . 'tarjeta_credito' . ' WHERE id_dueno = :id_dueno';
      $sql = $connx->prepare($query);
      $estado = 'APROBADO';
      $sql->bindParam(':id_dueno', $id_user);
      $sql->execute();
      $n = $sql->rowCount();
      if ($n > 0) {
        $respuesta = array();
        $respuesta['tarjeta_credito'] = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
          extract($fila);
          $cat_item = array(
            'id' => $id,
            'estado' => $estado,
            'id_ahorros' => $id_ahorros,
            'cupo_maximo' => $cupo_maximo,
            'gastado' => $gastado,
            'sobre_cupo' => $sobre_cupo,
            'tasa_interes' => $tasa_interes,
            'mora' => $mora,
            'cuota_manejo' => $cuota_manejo,
            'ultimo_pago' => $ultimo_pago,
            'fecha_creado' => $fecha_creado);
            array_push($respuesta['tarjeta_credito'], $cat_item);
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

    public static function get_single($id_cuenta,$conn)
    {
      try {
        $query = 'SELECT * FROM ' . 'tarjeta_credito' . ' WHERE id = :id_cuenta LIMIT 0,1';
        $sql = $conn->prepare($query);
        $sql->bindParam(':id_cuenta', $id_cuenta);
        $sql->execute();
        $n = $sql->rowCount();
        if ($n > 0) {
          $respuesta = array( );
          $respuesta['tarjeta_credito'] = array( );
          $fila = $sql->fetch(PDO::FETCH_ASSOC) ;
          extract($fila);
          $fila_r = array(     'id' => $id,
          'estado' => $estado,
          'id_ahorros' => $id_ahorros,
          'cupo_maximo' => $cupo_maximo,
          'gastado' => $gastado,
          'sobre_cupo' => $sobre_cupo,
          'tasa_interes' => $tasa_interes,
          'mora' => $mora,
          'cuota_manejo' => $cuota_manejo,
          'ultimo_pago' => $ultimo_pago,
          'fecha_creado' => $fecha_creado);
          array_push($respuesta['tarjeta_credito'], $fila_r);

          return array( 'band' => true , 'res' =>  $respuesta) ;
        } else {
          return array( 'band' => false , 'res' => 'nul') ;
        }
      } catch (PDOException $e) {
        return array( 'band' => false , 'res' => 'nul') ;
      }
      return array( 'band' => false , 'res' => 'nul') ;
    }

    public static function getUnaproved_Tarjetas($connx)
    {
      try {
        $query = 'SELECT * FROM ' . 'tarjeta_credito' . ' WHERE estado = :estado';
        $sql = $connx->prepare($query);
        $estado = 'EN_ESPERA';
        $sql->bindParam(':estado', $estado);
        $sql->execute();
        $n = $sql->rowCount();
        if ($n > 0) {
          $respuesta = array();
          $respuesta['tarjeta_credito'] = array();
          while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            extract($fila);
            $cat_item = array(
              'id' => $id,
              'estado' => $estado,
              'id_dueno' => $id_dueno,
              'id_ahorros' => $id_ahorros,
              'cupo_maximo' => $cupo_maximo,
              'gastado' => $gastado,
              'sobre_cupo' => $sobre_cupo,
              'tasa_interes' => $tasa_interes,
              'mora' => $mora,
              'cuota_manejo' => $cuota_manejo,
              'ultimo_pago' => $ultimo_pago,
              'fecha_creado' => $fecha_creado);
              array_push($respuesta['tarjeta_credito'], $cat_item);
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

      public function upDateTarjetaCredito($id_tarjeta_credito, $id_ahorros, $cupo_maximo ,$sobre_cupo , $tasa_interes, $cuota_manejo , $estado)
      {

        $query = 'UPDATE ' . 'tarjeta_credito' . ' SET estado = :estado,
                                                       id_ahorros = :id_ahorros,
                                                       cupo_maximo = :cupo_maximo,
                                                       sobre_cupo = :sobre_cupo,
                                                       tasa_interes = :tasa_interes,
                                                       cuota_manejo = :cuota_manejo WHERE id = :id';
        $stmt = $this->connection->prepare($query);

        $id_tarjeta_credito = htmlspecialchars(strip_tags($id_tarjeta_credito));
        $id_ahorros = htmlspecialchars(strip_tags($id_ahorros));
        $cupo_maximo = htmlspecialchars(strip_tags($cupo_maximo));
        $sobre_cupo = htmlspecialchars(strip_tags($sobre_cupo));
        $tasa_interes = htmlspecialchars(strip_tags($tasa_interes));
        $cuota_manejo = htmlspecialchars(strip_tags($cuota_manejo));
        $estado = htmlspecialchars(strip_tags($estado));

        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_ahorros', $id_ahorros);
        $stmt->bindParam(':cupo_maximo', $cupo_maximo);
        $stmt->bindParam(':sobre_cupo', $sobre_cupo);
        $stmt->bindParam(':tasa_interes', $tasa_interes);
        $stmt->bindParam(':cuota_manejo', $cuota_manejo);
        $stmt->bindParam(':id', $id_tarjeta_credito);
        try{
          if($stmt->execute()) {
            return true;
          }
        } catch (PDOException $e) {
          return false ;
        }

        return false;
      }

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
      * Get the value of Id Dueno
      *
      * @return mixed
      */
      public function getIdDueno()
      {
        return $this->idDueno;
      }

      /**
      * Set the value of Id Dueno
      *
      * @param mixed idDueno
      *
      * @return self
      */
      public function setIdDueno($idDueno)
      {
        $this->idDueno = $idDueno;

        return $this;
      }

      /**
      * Get the value of Id Ahorros
      *
      * @return mixed
      */
      public function getIdAhorros()
      {
        return $this->id_ahorros;
      }

      /**
      * Set the value of Id Ahorros
      *
      * @param mixed id_ahorros
      *
      * @return self
      */
      public function setIdAhorros($id_ahorros)
      {
        $this->id_ahorros = $id_ahorros;

        return $this;
      }

      /**
      * Get the value of Cupo Maximo
      *
      * @return mixed
      */
      public function getCupoMaximo()
      {
        return $this->cupoMaximo;
      }

      /**
      * Set the value of Cupo Maximo
      *
      * @param mixed cupoMaximo
      *
      * @return self
      */
      public function setCupoMaximo($cupoMaximo)
      {
        $this->cupoMaximo = $cupoMaximo;

        return $this;
      }

      /**
      * Get the value of Gastado
      *
      * @return mixed
      */
      public function getGastado()
      {
        return $this->gastado;
      }

      /**
      * Set the value of Gastado
      *
      * @param mixed gastado
      *
      * @return self
      */
      public function setGastado($gastado)
      {
        $this->gastado = $gastado;

        return $this;
      }

      /**
      * Get the value of Sobre Cupo
      *
      * @return mixed
      */
      public function getSobreCupo()
      {
        return $this->sobreCupo;
      }

      /**
      * Set the value of Sobre Cupo
      *
      * @param mixed sobreCupo
      *
      * @return self
      */
      public function setSobreCupo($sobreCupo)
      {
        $this->sobreCupo = $sobreCupo;

        return $this;
      }

      /**
      * Get the value of Tasa Interes
      *
      * @return mixed
      */
      public function getTasaInteres()
      {
        return $this->tasaInteres;
      }

      /**
      * Set the value of Tasa Interes
      *
      * @param mixed tasaInteres
      *
      * @return self
      */
      public function setTasaInteres($tasaInteres)
      {
        $this->tasaInteres = $tasaInteres;

        return $this;
      }

      /**
      * Get the value of Mora
      *
      * @return mixed
      */
      public function getMora()
      {
        return $this->mora;
      }

      /**
      * Set the value of Mora
      *
      * @param mixed mora
      *
      * @return self
      */
      public function setMora($mora)
      {
        $this->mora = $mora;

        return $this;
      }

      /**
      * Get the value of Cuota Manejo
      *
      * @return mixed
      */
      public function getCuotaManejo()
      {
        return $this->cuotaManejo;
      }

      /**
      * Set the value of Cuota Manejo
      *
      * @param mixed cuotaManejo
      *
      * @return self
      */
      public function setCuotaManejo($cuotaManejo)
      {
        $this->cuotaManejo = $cuotaManejo;

        return $this;
      }

      /**
      * Get the value of Fecha Ultimo Pago
      *
      * @return mixed
      */
      public function getFechaUltimoPago()
      {
        return $this->fecha_ultimo_pago;
      }

      /**
      * Set the value of Fecha Ultimo Pago
      *
      * @param mixed fecha_ultimo_pago
      *
      * @return self
      */
      public function setFechaUltimoPago($fecha_ultimo_pago)
      {
        $this->fecha_ultimo_pago = $fecha_ultimo_pago;

        return $this;
      }

      /**
      * Get the value of Fecha Creado
      *
      * @return mixed
      */
      public function getFechaCreado()
      {
        return $this->fecha_creado;
      }

      /**
      * Set the value of Fecha Creado
      *
      * @param mixed fecha_creado
      *
      * @return self
      */
      public function setFechaCreado($fecha_creado)
      {
        $this->fecha_creado = $fecha_creado;

        return $this;
      }

      /**
      * Get the value of Estado
      *
      * @return mixed
      */
      public function getEstado()
      {
        return $this->estado;
      }

      /**
      * Set the value of Estado
      *
      * @param mixed estado
      *
      * @return self
      */
      public function setEstado($estado)
      {
        $this->estado = $estado;

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
    }
