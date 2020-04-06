<?
require_once "../modelo/Pago.php";

$action = '';

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

switch ($action) {   

   case 'getPagosByIdExp': 
      $pago = new Pago();

      $pago->idexpediente = $_GET['idexpediente'];      
      $result = $pago->getPagosPorExpediente();

      echo json_encode($result);
      break; 

   case 'store': 
      $pago = new Pago();

      $pago->idconcepto = $_POST['idconcepto'];
      $pago->concepto = $_POST['concepto'];
      $pago->monto = $_POST['monto'];
      $pago->fecha_pago = $_POST['fecha_pago'];
      $pago->nro_recibo = $_POST['nro_recibo'];
      $pago->idexpediente = $_POST['idexpediente'];

      $result = $pago->insertar();

      echo json_encode($result);
      break;    
}
?>



