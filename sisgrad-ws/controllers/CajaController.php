<?php
require_once 'models/Caja.php';

class CajaController {

	public function getPagosProfesionalTesis(){
		$caja = new Caja();        
        $cui = '20143489';
		$nues = '450';        
		$espe = '0';
		/*$cui = $_POST['cui'];
		$nues = $_POST['nues'];
		$espe = $_POST['espe'];*/

        $result = $caja->getPagosProfesionalTesis($cui, $nues, $espe);

        echo json_encode($result);
	}
}