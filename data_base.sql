/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user VARCHAR (50) NOT NULL UNIQUE,
  password VARCHAR (512) NOT NULL,
  nombre VARCHAR (50),
  apellido VARCHAR (50),
  emailadd VARCHAR (255) NOT NULL UNIQUE,
  rol ENUM ('admin','user') NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS visitante  (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  emailadd VARCHAR (255) NOT NULL UNIQUE,
  cedula VARCHAR (10) NOT NULL UNIQUE,
  nombre VARCHAR (50),
  apellido VARCHAR (50),
  PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS credito  (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  tasa_interes FLOAT NOT NULL,
  monto INT UNSIGNED NOT NULL,
  fecha_pago DATETIME NOT NULL,
  fecha_creado DATETIME DEFAULT CURRENT_TIMESTAMP,
  id_dueno INT ,
  email_vis VARCHAR(244),
  ultimo_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY (id_dueno)
      REFERENCES usuarios(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS cuenta_ahorros  (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  tasa_interes FLOAT NOT NULL,
  monto INT UNSIGNED NOT NULL,
  id_dueno INT NOT NULL,
  fecha_creado DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY (id_dueno)
      REFERENCES usuarios(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS tarjeta_credito  (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  id_dueno INT NOT NULL,
  cupo_maximo INT UNSIGNED NOT NULL,
  gastado INT UNSIGNED NOT NULL,
  sobre_cupo INT UNSIGNED NOT NULL,
  tasa_interes FLOAT NOT NULL,
  cuota_manejo FLOAT NOT NULL,
  ultimo_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  fecha_creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY (id_dueno)
      REFERENCES usuarios(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS operaciones_admin  (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  nombre_operacion VARCHAR(30) NOT NULL,
  PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS movimientos_admin  (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  id_admin INT NOT NULL,
  id_producto INT NOT NULL,
  id_operacion INT NOT NULL,
  fecha_realizado DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY (id_admin)
      REFERENCES usuarios(id)
      ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (id_operacion)
      REFERENCES operaciones_admin(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS retiro (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  id_ahorros INT NOT  NULL,
  monto INT UNSIGNED NOT NULL,
  fecha_realizado DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY (id_ahorros)
      REFERENCES cuenta_ahorros(id)
      ON UPDATE CASCADE ON DELETE RESTRICT
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS consignacion_credito (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  id_destino INT NOT  NULL,
  monto INT UNSIGNED NOT NULL,
  fecha_realizado DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_destino)
    REFERENCES credito (id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS consignacion_debito (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  id_destino INT NOT  NULL,
  monto INT UNSIGNED NOT NULL,
  fecha_realizado DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_destino)
    REFERENCES cuenta_ahorros (id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS compra_credito (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  id_producto INT NOT  NULL,
  monto INT UNSIGNED NOT NULL,
  fecha_realizado DATETIME DEFAULT CURRENT_TIMESTAMP,
  numero_cuenta INT UNSIGNED NOT NULL,
  FOREIGN KEY (id_producto)
    REFERENCES tarjeta_credito (id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
CREATE TABLE IF NOT EXISTS mensajes (
  id INT NOT NULL AUTO_INCREMENT UNIQUE,
  id_origen INT NOT NULL,
  id_destino INT NOT NULL,
  contenido TEXT NOT NULL,
  FOREIGN KEY (id_origen)
    REFERENCES usuarios (id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (id_destino)
      REFERENCES usuarios (id)
      ON UPDATE CASCADE ON DELETE RESTRICT,
  PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*--------------------------------------------------------------------------------------------*/
INSERT INTO operaciones_admin (nombre_operacion) VALUES ('aprobar_credito'),
                                                            ('aprobar_ahorros'),
                                                            ('aprobar_tarjeta_credito'),
                                                            ('aprueba_cupo') ,
                                                            ('aprueba_sobrecupo');
/*--------------------------------------------------------------------------------------------*/
