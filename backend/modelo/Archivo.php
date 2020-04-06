<?
require_once 'conexion.php';

class Archivo {
   public $id;   
   public $nombre;
   public $data;
   public $extension;
   public $idgrado_proc;
   public $idusuario;
   public $idexpediente; 

   private $conn;   

   public function __construct() {
      $mysql = new ConexionMySql();
      $this->conn = $mysql->connect();      
   }

   public function getTodosArchivos() {

      $result = array('error' => false);

      $sql = "SELECT GT_A.*, GT_P.nombre AS procedimiento, GT_RA.nombre AS area FROM 
              GT_ARCHIVO AS GT_A 
              INNER JOIN GT_GRADO_PROCEDIMIENTO GT_GP ON GT_A.idgrado_proc = GT_GP.id
              INNER JOIN GT_PROCEDIMIENTO GT_P ON GT_GP.idprocedimiento = GT_P.id
              INNER JOIN GT_USUARIO GT_U ON GT_A.idusuario = GT_U.id
              INNER JOIN GT_ROL_AREA GT_RA ON GT_U.idrol_area = GT_RA.id
              WHERE idexpediente = $this->idexpediente ORDER BY id ASC";
      $result_query = mysqli_query($this->conn, $sql);

      $array_archivo = array();

      while ($row = $result_query->fetch_assoc()) {         
         array_push($array_archivo, $row);
      }

      $result['array_archivo'] = $array_archivo;      

      return $result;
   }   

   public function getDocumento() {

      $result = array('error' => false);

      $sql = "SELECT * FROM GT_ARCHIVO 
              WHERE idgrado_proc = $this->idgrado_proc
              AND idusuario = $this->idusuario
              AND idexpediente = $this->idexpediente";
      $result_query = mysqli_query($this->conn, $sql);

      $array_documento = array();

      while ($row = $result_query->fetch_assoc()) {         
         array_push($array_documento, $row);
      }

      $result['array_documento'] = $array_documento;      

      return $result;
   }

   public function storeDocumento(){
      $result = array('error' => false);      

      $sql = "INSERT INTO GT_ARCHIVO(nombre, data, extension, idgrado_proc, idusuario, idexpediente) 
              VALUES ('$this->nombre', '$this->data', '$this->extension', $this->idgrado_proc, $this->idusuario, $this->idexpediente)";
      $result_query = mysqli_query($this->conn, $sql);

      if ($result_query) {
          $result['message'] = "Archivo agregado correctamente.";
      }
      else {
          $result['error'] = true;
          $result['message'] = "No se pudo agregar el archivo.";
      }           

      return $result;
   }

   public function deleteDocumento(){
      $result = array('error' => false);      

      $sql = "DELETE FROM GT_ARCHIVO WHERE id = $this->id";
      
      $result_query = mysqli_query($this->conn, $sql);

      if ($result_query) {
          $result['message'] = "Archivo eliminado correctamente.";
      }
      else {
          $result['error'] = true;
          $result['message'] = "No se pudo eliminar el archivo.";
      }           

      return $result;
   }
   
}
?>