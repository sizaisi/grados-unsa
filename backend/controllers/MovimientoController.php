<?php
require_once 'models/Movimiento.php';

class MovimientoController {
	
	public function mover() {
		$movimiento = new Movimiento();

		$movimiento->setIdUsuario($_POST['idusuario']);   
		$movimiento->setIdExpediente($_POST['idexpediente']);                                         
		$movimiento->setIdRuta($_POST['idruta']);
		$idgradproc_destino = $_POST['idgradproc_destino'];                                                     

		$result = $movimiento->mover($idgradproc_destino);

		echo json_encode($result);        
	}
	
	public function deshacer() {
		$movimiento = new Movimiento();

		$movimiento->setId($_POST['id']); //idmovimiento       
		$idgradproc_origen = $_POST['idgradproc_origen'];                                                     

		$result = $movimiento->deshacer($idgradproc_origen);

		echo json_encode($result);       
	}	
	
	// obtener ruta entrada por el procedimiento destino
	public function getLastMovimientoByProc() { 
		$movimiento = new Movimiento();
		
		$idgradproc_destino = $_POST['idgradproc_destino'];  		  
		$movimiento->setIdExpediente($_POST['idexpediente']);		

		$result = $movimiento->getLastMovimiento($idgradproc_destino);

		echo json_encode($result);             
	}
}