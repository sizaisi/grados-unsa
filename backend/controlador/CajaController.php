<?
require_once "../servicios/ServicioCaja.php";
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    case 'getPagosCajaProfesionalTesis':    
        $servicio_caja = new ServicioCaja();
        
        $cui = '20143489';
        $depe = '450';        

        $result = $servicio_caja->getPagosCajaProfesionalTesis($cui, $depe);

        echo json_encode($result);

        break;    
}

?>