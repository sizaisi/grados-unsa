<?
require_once 'conexion.php';

class Movimiento {      
   public $id;
   public $idexpediente;
   public $idusuario;
   public $idruta;   
   
   private $conn;   

   public function __construct() {
      $mysql = new ConexionMySql();
      $this->conn = $mysql->connect();      
   }

   // registrar movimiento y actualizar procedimiento del expediente con el idgradprod_destino
   public function mover($idgradproc_destino) {      
      
      $result = array('error' => false);                
      $this->conn->autocommit(FALSE); //iniciar transaccion
      
      //realizar movimiento con la ruta seleccionada
      $sql = "INSERT INTO GT_MOVIMIENTO(idexpediente, idusuario, idruta) 
              VALUES ($this->idexpediente, $this->idusuario, $this->idruta)";      
      $result_query = mysqli_query($this->conn, $sql);     

      if (!$result_query) {
         $result['error'] = true;                    
      }     

      //actualizar expediente para conocer en que procedimiento se encuentra
      $sql = "UPDATE GT_EXPEDIENTE SET idgrado_procedimiento = $idgradproc_destino
              WHERE id = $this->idexpediente";        
      $result_query = mysqli_query($this->conn, $sql);

      if (!$result_query) {
         $result['error'] = true;                    
      }

      //verificar y realizar transaccion
      if($result['error'] == false) { //si no hay ningun error en querys
         $this->conn->commit();          
         $result['message'] = "El expediente fue enviado satisfactoriamente.";
      }
      else {
         $this->conn->rollback(); // deshacer transaccion
         $result['message'] = "No se pudo enviar el expediente.";
      }

      $this->conn->autocommit(TRUE); //finalizar transaccion

      return $result;     
   }      

   // eliminar movimiento y actualizar procedimiento del expediente con el idgradprod_origen
   public function deshacer($idgradproc_origen) {      
      
      $result = array('error' => false);                
      $this->conn->autocommit(FALSE); //iniciar transaccion
      
      //eliminar el ultimo movimiento realizado
      $sql = "DELETE FROM GT_MOVIMIENTO WHERE id = $this->id";      
      $result_query = mysqli_query($this->conn, $sql);     

      if (!$result_query) {
         $result['error'] = true;                    
      }     

      //actualizar expediente para conocer en que procedimiento se encuentra
      $sql = "UPDATE GT_EXPEDIENTE SET idgrado_procedimiento = $idgradproc_origen
              WHERE id = $this->idexpediente";        
      $result_query = mysqli_query($this->conn, $sql);

      if (!$result_query) {
         $result['error'] = true;                    
      }

      //verificar y realizar transaccion
      if($result['error'] == false) { //si no hay ningun error en querys
         $this->conn->commit();          
         $result['message'] = "El movimiento fue eliminado satisfactoriamente.";
      }
      else {
         $this->conn->rollback(); // deshacer transaccion
         $result['message'] = "No se pudo eliminar el movimiento.";
      }

      $this->conn->autocommit(TRUE); //finalizar transaccion

      return $result;     
   }      
   
}
?>