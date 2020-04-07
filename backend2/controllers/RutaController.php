<?php
require_once 'models/Ruta.php';

class RutaController {
	
	public function index(){
		$ruta = new Ruta();

		$result = $ruta->getAllRutas();

		echo json_encode($result);            
	}
	
	public function store(){
		$ruta = new Ruta();

		$ruta->idgradproc_origen = $_POST['idgradproc_origen'];
		$ruta->idgradproc_destino = $_POST['idgradproc_destino'];
		$ruta->etiqueta = $_POST['etiqueta'];            

		$result = $ruta->insertar();

		echo json_encode($result);       
	}
	
	public function update(){
		$ruta = new Ruta();

		$ruta->id = $_POST['id'];
		$ruta->idgradproc_origen = $_POST['idgradproc_origen'];
		$ruta->idgradproc_destino = $_POST['idgradproc_destino'];            
		$ruta->etiqueta = $_POST['etiqueta'];

		$result = $ruta->actualizar();

		echo json_encode($result);             
	}
	
	public function activar(){
		$ruta = new Ruta();

		$ruta->id = $_POST['id'];

		$result = $ruta->activar();

		echo json_encode($result);             
	}	
	
	public function desactivar(){
		$ruta = new Ruta();

		$ruta->id = $_POST['id'];
  
		$result = $ruta->desactivar();
  
		echo json_encode($result);             
	}	
}