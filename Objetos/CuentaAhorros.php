<?php
    class CuentaAhorros
    {
        private $id;
        private $cuotaManejo;
        private $tasa_interes ;
        private $fecha_creado ;
        private $idDueno;
        private $saldo;
        private $estado;
        private $connection ;

        public function __construct($conn)
        {
            $this->connection = $conn ;
        }

        public function create_ahorros()
        {
            try{
              $query = 'INSERT INTO ' . 'cuenta_ahorros' . ' SET tasa_interes = :tasa_interes, saldo = :saldo, id_dueno = :id_dueno, cuota_manejo = :cuota_manejo';
              $sql = $this->connection->prepare($query);

              $this->saldo = htmlspecialchars(strip_tags($this->saldo));
              $this->fecha_creado = time() ;
              $this->cuotaManejo = 0 ;

              $sql->bindParam(':tasa_interes', $this->tasa_interes);
              $sql->bindParam(':saldo', $this->saldo);
              $sql->bindParam(':id_dueno', $this->idDueno);
              $sql->bindParam(':cuota_manejo', $this->cuotaManejo);

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
         * Get the value of Tasa Interes
         *
         * @return mixed
         */
        public function getTasaInteres()
        {
            return $this->tasa_interes;
        }

        /**
         * Set the value of Tasa Interes
         *
         * @param mixed tasa_interes
         *
         * @return self
         */
        public function setTasaInteres($tasa_interes)
        {
            $this->tasa_interes = $tasa_interes;

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
         * Get the value of Saldo
         *
         * @return mixed
         */
        public function getSaldo()
        {
            return $this->saldo;
        }

        /**
         * Set the value of Saldo
         *
         * @param mixed saldo
         *
         * @return self
         */
        public function setSaldo($saldo)
        {
            $this->saldo = $saldo;

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
