<?php
class ConexionMySql  
{
  private $host = 'localhost';
  private $user = 'root';
  private $pass = '';
  private $db = 'siac_pruebas';
  private $conexion;

  public function connect() {            
      $con = new mysqli($this->host, $this->user, $this->pass, $this->db);  
            
      if (mysqli_connect_errno()) {
        //echo mysqli_connect_error();
        die('No se pudo conectar a la base de datos del sistema académico!');
      } 
      else {
        $con->query("SET CHARACTER SET 'utf8'");
        $con->query( 'SET @@global.max_allowed_packet = ' . 50 * 1024 * 1024 );
        $this->conexion = $con;          
      }

      return $this->conexion;
  }

  public function close() {
    $this->conexion->close();      
  }
}
?>
