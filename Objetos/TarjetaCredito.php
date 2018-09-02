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
            // code...
        }
        /* GETTERS AND SETTERS */


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
