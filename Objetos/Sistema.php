<?php
include_once dirname(__FILE__) . '/Usuario.php';
include_once dirname(__FILE__) . '/ManejoCorreo.php';

class Sistema{
  private $connection ;
  private $interes;
  private $usuarios = [];
  private $mailer;

  function __construct($interes, $conn){
    $this->interes = $interes;
    $this->connection = $conn ;
  }
  function addUsuario($usuario){
    array_push($this->usuarios,$usuario);
  }
  function enviarMail($username,$correo,$asunto,$mensaje){
    $this->mailer = new ManejoCorreo($correo,$asunto,$mensaje);
    $this->mailer->enviarMail($username);
  }
  public function upDateInteresAhorros($value)
  {
    $query = 'UPDATE ' . 'sistema' . '
    SET interes_aumento = :interes_aumento
    WHERE id = :id';

    $stmt = $this->connection->prepare($query);

    $value = htmlspecialchars(strip_tags($value));
    $id = 1 ;

    $stmt->bindParam(':interes_aumento', $value);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()) {
      return true;
    }

    return false;
  }
  public function upDateInteresInterBanco($value)
  {
    $query = 'UPDATE ' . 'sistema' . '
    SET interes_inter_banco = :interes_inter_banco
    WHERE id = :id';

    $stmt = $this->connection->prepare($query);

    $value = htmlspecialchars(strip_tags($value));
    $id = 1 ;

    $stmt->bindParam(':interes_inter_banco', $value);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()) {
      return true;
    }

    return false;
  }
  public function upDateCuota_Manejo($value)
  {
    $query = 'UPDATE ' . 'sistema' . '
    SET cuota_manejo_default = :cuota_manejo_default
    WHERE id = :id';

    $stmt = $this->connection->prepare($query);

    $value = htmlspecialchars(strip_tags($value));
    $id = 1 ;

    $stmt->bindParam(':cuota_manejo_default', $value);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()) {
      return true;
    }

    return false;
  }

}
?>
