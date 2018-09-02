<?php
    class Credito{
        private $id;
        private $tasaInteres;
        private $interesMora;
        private $monto ;
        private $fechaCreado;
        private $dueno  ;
        private $email_vis ;
        private $ultimo_pago ;
        private $connection ;

        function __construct($conn){
            $this->connection = $conn ;
        }

        public function create_credito_user()
        {
          try{
            $query = 'INSERT INTO ' . 'credito' . ' SET tasa_interes = :tasa_interes, interes_mora = :interes_mora, monto = :monto, id_dueno = :id_dueno, email_vis = :email_vis';
            $sql = $this->connection->prepare($query);

            $this->tasaInteres = htmlspecialchars(strip_tags($this->tasaInteres));
            $this->monto = htmlspecialchars(strip_tags($this->monto));
            $this->fechaCreado = time() ;
            $this->interesMora = 0 ;
            $this->email_vis = "N/A";

            $sql->bindParam(':tasa_interes', $this->tasaInteres);
            $sql->bindParam(':monto', $this->monto);
            $sql->bindParam(':id_dueno', $this->dueno);
            $sql->bindParam(':interes_mora', $this->interesMora);
            $sql->bindParam(':email_vis', $this->email_vis);

            if ($sql->execute()) {
                return "exito";
            }

          }catch (PDOException $e) {
              return "error " .  $e->getMessage();
          }
          return "error";
        }

        public function create_credito_visitante()
        {
          try{
            $query = 'INSERT INTO ' . 'credito' . ' SET tasa_interes = :tasa_interes, interes_mora = :interes_mora, monto = :monto,email_vis = :email_vis';
            $sql = $this->connection->prepare($query);

            $this->tasaInteres = htmlspecialchars(strip_tags($this->tasaInteres));
            $this->monto = htmlspecialchars(strip_tags($this->monto));
            $this->fechaCreado = time() ;
            $this->interesMora = 0 ;

            $sql->bindParam(':tasa_interes', $this->tasaInteres);
            $sql->bindParam(':monto', $this->monto);
            $sql->bindParam(':interes_mora', $this->interesMora);
            $sql->bindParam(':email_vis', $this->email_vis);

            if ($sql->execute()) {
                return "exito";
            }

          }catch (PDOException $e) {
              return "error " .  $e->getMessage();
          }
          return "error";
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
     * Get the value of Interes Mora
     *
     * @return mixed
     */
    public function getInteresMora()
    {
        return $this->interesMora;
    }

    /**
     * Set the value of Interes Mora
     *
     * @param mixed interesMora
     *
     * @return self
     */
    public function setInteresMora($interesMora)
    {
        $this->interesMora = $interesMora;

        return $this;
    }

    /**
     * Get the value of Monto
     *
     * @return mixed
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set the value of Monto
     *
     * @param mixed monto
     *
     * @return self
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get the value of Fecha Creado
     *
     * @return mixed
     */
    public function getFechaCreado()
    {
        return $this->fechaCreado;
    }

    /**
     * Set the value of Fecha Creado
     *
     * @param mixed fechaCreado
     *
     * @return self
     */
    public function setFechaCreado($fechaCreado)
    {
        $this->fechaCreado = $fechaCreado;

        return $this;
    }

    /**
     * Get the value of Dueno
     *
     * @return mixed
     */
    public function getDueno()
    {
        return $this->dueno;
    }

    /**
     * Set the value of Dueno
     *
     * @param mixed dueno
     *
     * @return self
     */
    public function setDueno($dueno)
    {
        $this->dueno = $dueno;

        return $this;
    }

    /**
     * Get the value of Email Vis
     *
     * @return mixed
     */
    public function getEmailVis()
    {
        return $this->email_vis;
    }

    /**
     * Set the value of Email Vis
     *
     * @param mixed email_vis
     *
     * @return self
     */
    public function setEmailVis($email_vis)
    {
        $this->email_vis = $email_vis;

        return $this;
    }

    /**
     * Get the value of Ultimo Pago
     *
     * @return mixed
     */
    public function getUltimoPago()
    {
        return $this->ultimo_pago;
    }

    /**
     * Set the value of Ultimo Pago
     *
     * @param mixed ultimo_pago
     *
     * @return self
     */
    public function setUltimoPago($ultimo_pago)
    {
        $this->ultimo_pago = $ultimo_pago;

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
?>
