<?php
require_once 'models/Movimiento.php';

class MovimientoController {

	// obtener ruta entrada por el procedimiento destino
	public function ultimoMovimiento() { 
		$movimiento = new Movimiento();
		
		$idgradproc_destino = $_POST['idgradproc_destino'];  		  
		$movimiento->setIdExpediente($_POST['idexpediente']);		

		$result = $movimiento->getLastMovimiento($idgradproc_destino);

		echo json_encode($result);          
	}

	// obtener los expedientes enviados que no hay sido aceptados por el sgte procedimiento
	public function expedientes_enviados() { 
		$movimiento = new Movimiento();
		
		$movimiento->setIdUsuario($_POST['idusuario']);
		$idgradproc_origen = $_POST['idgradproc_origen'];  		  		

		$result = $movimiento->getExpedientesEnviados($idgradproc_origen);

		echo json_encode($result);          
	}
	
	public function mover() {
		$movimiento = new Movimiento();

		$movimiento->setIdUsuario($_POST['idusuario']);   
		$movimiento->setIdExpediente($_POST['idexpediente']);                                         
		$movimiento->setIdRuta($_POST['idruta']);
		$movimiento->setIdMovAnterior($_POST['idmov_anterior']);
		$idgradproc_origen = $_POST['idgradproc_origen'];                                                     
		$idgradproc_destino = $_POST['idgradproc_destino'];
		$estado_expediente = $_POST['estado_expediente'];                                                     

		$result = $movimiento->mover($idgradproc_origen, $idgradproc_destino, $estado_expediente);

		echo json_encode($result);        
	}
	
	public function deshacer() {
		$movimiento = new Movimiento();

		$movimiento->setId($_POST['id']); //idmovimiento    
		$movimiento->setIdExpediente($_POST['idexpediente']);   
		$idgradproc_origen = $_POST['idgradproc_origen'];
		$fecha_ant = $_POST['fecha_ant'];
		$estado_expediente_ant = $_POST['estado_expediente_ant'];

		$result = $movimiento->deshacer($idgradproc_origen, $fecha_ant, $estado_expediente_ant);

		echo json_encode($result);       
	}		
}