<?php
require_once 'models/Autoridad.php';

class AutoridadController {
	
	public function index(){
		
		$autoridad = new Autoridad();

		$result = $autoridad->getAllAutoridad();

		echo json_encode($result);
	}
	
	public function store(){
		$autoridad = new Autoridad();

		$autoridad->setNombre($_POST['nombre']);
		$autoridad->setGrado($_POST['grado']);

		$result = $autoridad->insertar();

		echo json_encode($result);
	}
	
	public function update(){
		$autoridad = new Autoridad();

		$autoridad->setId($_POST['id']);
		$autoridad->setNombre($_POST['nombre']);
		$autoridad->setGrado($_POST['grado']);
		
		$result = $autoridad->actualizar();

		echo json_encode($result);
	            
	}
	
	public function activar(){
		$autoridad = new Autoridad();

		$autoridad->setId($_POST['id']);

		$result = $autoridad->activar();

		echo json_encode($result);
	}	
	
	public function desactivar(){
	    $autoridad = new Autoridad();

		$autoridad->setId($_POST['id']);      

		$result = $autoridad->desactivar();

		echo json_encode($result);   
	}	
}