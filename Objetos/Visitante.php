<?php
    class Visitante
    {
        private $id ;
        private $email;
        private $nombre ;
        private $apellido;
        private $cedula;
        private $connection;

        public function __construct($conn)
        {
            $this->connection = $conn;
        }

        public function create_visitante()
        {
            try {
                $query = 'INSERT INTO ' . 'visitante' . ' SET emailadd = :emailadd, cedula = :cedula, nombre = :nombre, apellido = :apellido';
                $sql = $this->connection->prepare($query);

                $this->nombre = htmlspecialchars(strip_tags($this->nombre));
                $this->apellido = htmlspecialchars(strip_tags($this->apellido));
                $this->email = htmlspecialchars(strip_tags($this->email));
                $this->cedula = htmlspecialchars(strip_tags($this->cedula));

                $sql->bindParam(':emailadd', $this->email);
                $sql->bindParam(':cedula', $this->cedula);
                $sql->bindParam(':nombre', $this->nombre);
                $sql->bindParam(':apellido', $this->apellido);
                if ($sql->execute()) {
                    return "exito";
                }
            } catch (PDOException $e) {
                return "error " .  $e->getMessage();
            }
            return "error";
        }

        public function exist_visitante()
        {
          try {
              $query = 'SELECT id, cedula FROM ' . 'visitante' . ' WHERE emailadd = :emailadd LIMIT 0,1';
              $sql = $this->connection->prepare($query);
              $this->email = htmlspecialchars(strip_tags($this->email));
              $sql->bindParam(':emailadd', $this->email);
              $sql->execute();
              $res = $sql->fetch(PDO::FETCH_ASSOC);

              if (!empty($res)) {
                  $this->id = $res['id'];
                  $this->cedula = $res['cedula'];
                  return "success";
              } else {
                  return "error" ;
              }
          } catch (PDOException $e) {
              return "error";
          }
          return "error";
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
         * Get the value of Cedula
         *
         * @return mixed
         */
        public function getCedula()
        {
            return $this->cedula;
        }

        /**
         * Set the value of Cedula
         *
         * @param mixed cedula
         *
         * @return self
         */
        public function setCedula($cedula)
        {
            $this->cedula = $cedula;

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
    }
