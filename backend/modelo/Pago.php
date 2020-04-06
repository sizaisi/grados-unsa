<?
require_once 'conexion.php';

class Pago {
   public $id;
   public $idconcepto;
   public $concepto;
   public $monto;
   public $fecha_pago;
   public $nro_recibo;
   public $idexpediente;

   private $conn;   

   public function __construct() {
      $mysql = new ConexionMySql();
      $this->conn = $mysql->connect();      
   }

   public function getPagosPorExpediente() {

      $result = array('error' => false);

      $sql = "SELECT * FROM GT_PAGO WHERE idexpediente = $this->idexpediente";
      $result_query = mysqli_query($this->conn, $sql);

      $array_pagos_expediente = array();

      while ($row = $result_query->fetch_assoc()) {         
         array_push($array_pagos_expediente, $row);
      }

      $result['array_pagos_expediente'] = $array_pagos_expediente;      

      return $result;
   }

   public function insertar() {      

      $result = array('error' => false);

      $sql = "INSERT INTO GT_PAGO(idconcepto, concepto, monto, fecha_pago, nro_recibo, idexpediente)
              VALUES ($this->idconcepto, '$this->concepto', $this->monto,
                      '$this->fecha_pago', '$this->nro_recibo', $this->idexpediente)";

      $result_query = mysqli_query($this->conn, $sql);

      if ($result_query) {
         $result['message'] = "Pago agregado correctamente.";
      }
      else {
         $result['error'] = true;
         $result['message'] = "No se pudo agregar el pago.";
      }      

      return $result;
   } 
}
?>