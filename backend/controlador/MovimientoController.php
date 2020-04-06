<?
require_once "../modelo/Movimiento.php";

$action = '';

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

switch ($action) {       

  case 'mover':
    $movimiento = new Movimiento();

    $movimiento->idusuario = $_POST['idusuario'];   
    $movimiento->idexpediente = $_POST['idexpediente'];                                         
    $movimiento->idruta = $_POST['idruta'];
    $idgradproc_destino = $_POST['idgradproc_destino'];                                                     

    $result = $movimiento->mover($idgradproc_destino);

    echo json_encode($result);       

    break;        

  case 'deshacer':
    $movimiento = new Movimiento();

    $movimiento->id = $_POST['id']; //idmovimiento       
    $idgradproc_origen = $_POST['idgradproc_origen'];                                                     

    $result = $movimiento->deshacer($idgradproc_origen);

    echo json_encode($result);       

    break;        
}
?>



