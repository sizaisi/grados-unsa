<?php
class ConexionCajaMySql  
{
  private $host = '10.20.1.1';
  private $user = 'sisacad_caja';
  private $pass = 'sisca05';
  private $db = 'DB_CAJA';
  private $myconn;

  public function connect() {
      $con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
      mysqli_query($con,"SET CHARACTER SET 'utf8'");
      
      if (!$con) {
          die('No se pudo conectar a la base de datos de caja!');
      } else {
          $this->myconn = $con;          
      }

      return $this->myconn;
  }

  public function close() {
      mysqli_close($this->myconn);      
  }
}
?>
