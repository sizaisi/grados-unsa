<?
require_once 'conexion.php';

class UsuarioExpediente {
   public $id;
   public $idexpediente;
   public $idusuario;
   public $tipo;
      
   private $conn;   

   public function __construct() {
      $mysql = new ConexionMySql();
      $this->conn = $mysql->connect();      
   }

   public function getAsesor($idexpediente) {

      $result = array('error' => false);

      $sql = "SELECT GT_UE.id, REPLACE(AC_D.apn, '/', ' ') AS nombre_docente, AC_DE.ndep AS departamento
              FROM GT_USUARIO_EXPEDIENTE AS GT_UE
              INNER JOIN GT_USUARIO AS GT_U ON GT_UE.idusuario = GT_U.id                
              INNER JOIN SIAC_DOC AS AC_D ON GT_U.codi_usuario = AC_D.codper
              INNER JOIN actdepa AS AC_DE ON AC_D.depend = AC_DE.depa
              WHERE GT_UE.idexpediente = $idexpediente AND GT_UE.tipo = 'asesor'";

      $result_query = mysqli_query($this->conn, $sql);

      $array_asesor = array();

      while ($row = $result_query->fetch_assoc()) {         
         array_push($array_asesor, $row);
      }

      $result['array_asesor'] = $array_asesor;

      return $result;
   }    

   public function getNombreAsesor($idexpediente) {

      $result = array('error' => false);

      $sql = "SELECT REPLACE(AC_D.apn, '/', ' ') as nombre_docente
              FROM GT_USUARIO_EXPEDIENTE AS GT_UE
              INNER JOIN GT_USUARIO AS GT_U ON GT_UE.idusuario = GT_U.id                
              INNER JOIN SIAC_DOC AS AC_D ON GT_U.codi_usuario = AC_D.codper
              WHERE GT_UE.idexpediente = $idexpediente AND GT_UE.tipo = 'asesor'";
      $result_query = mysqli_query($this->conn, $sql);
      $row = $result_query->fetch_assoc();      

      $result['nombre_asesor'] = $row['nombre_docente'] != null ? $row['nombre_docente'] : '';

      return $result;
   }       

   public function getExpJurados($idexpediente) {

      $result = array('error' => false);

      $sql = "SELECT GT_UE.id, GT_UE.idexpediente, GT_UE.idusuario, GT_UE.tipo, REPLACE(AC_D.apn, '/', ' ') AS nombre
              FROM GT_USUARIO_EXPEDIENTE AS GT_UE
              INNER JOIN GT_USUARIO AS GT_U ON GT_UE.idusuario = GT_U.id                
              INNER JOIN SIAC_DOC AS AC_D ON GT_U.codi_usuario = AC_D.codper
              WHERE GT_UE.tipo <> 'granduado' AND  GT_UE.tipo <> 'asesor' 
              AND GT_UE.idexpediente = $idexpediente
              ORDER BY GT_UE.id ASC";

      $result_query = mysqli_query($this->conn, $sql);

      $array_expediente_jurado = array();

      while ($row = $result_query->fetch_assoc()) {         
         array_push($array_expediente_jurado, $row);
      }

      $result['array_expediente_jurado'] = $array_expediente_jurado;   

      return $result;
   }    

   public function insertar_asesor() {      

      $result = array('error' => false);

      $sql = "INSERT INTO GT_USUARIO_EXPEDIENTE(idexpediente, idusuario, tipo) 
               VALUES ($this->idexpediente, $this->idusuario, '$this->tipo')";
      
      $result_query = mysqli_query($this->conn, $sql);

      if ($result_query) {
         $result['message'] = "Asesor agregado correctamente.";
      }
      else {
         $result['error'] = true;
         $result['message'] = $sql;
      }      

      return $result;
   }

   public function deleteAsesor(){
      $result = array('error' => false);      

      $sql = "DELETE FROM GT_USUARIO_EXPEDIENTE WHERE id = $this->id";
      
      $result_query = mysqli_query($this->conn, $sql);

      if ($result_query) {
          $result['message'] = "Asesor eliminado correctamente.";
      }
      else {
          $result['error'] = true;
          $result['message'] = "No se pudo eliminar el asesor.";
      }           

      return $result;
   }

   public function insertar_jurado() {      

      $result = array('error' => false);

      $sql = "INSERT INTO GT_USUARIO_EXPEDIENTE(idexpediente, idusuario, tipo) 
               VALUES ($this->idexpediente, $this->idusuario, '$this->tipo')";
      
      $result_query = mysqli_query($this->conn, $sql);

      if ($result_query) {
         $result['message'] = "Jurado agregado correctamente.";
      }
      else {
         $result['error'] = true;
         $result['message'] = "No se pudo agregar el jurado.";
      }      

      return $result;
   }

   public function eliminar_jurado() {      

      $result = array('error' => false);

      $sql = "DELETE FROM GT_USUARIO_EXPEDIENTE where id = $this->id";
      
      $result_query = mysqli_query($this->conn, $sql);

      if ($result_query) {
         $result['message'] = "Jurado eliminado correctamente.";
      }
      else {
         $result['error'] = true;
         $result['message'] = "No se pudo eliminar el jurado.";
      }      

      return $result;
   }
}
?>