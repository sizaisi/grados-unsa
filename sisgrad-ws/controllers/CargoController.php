<?php
require_once 'models/Cargo.php';

class CargoController {
	
	public function index(){
		
		$cargo = new Cargo();

		$result = $cargo->getAllCargo();

		echo json_encode($result);
	}
	
	public function store(){
		$cargo = new Cargo();

		$cargo->setCodigo($_POST['codigo']);
		$cargo->setNombre($_POST['nombre']);

		$result = $cargo->insertar();

		echo json_encode($result);
	}
	
	public function update(){
		$cargo = new Cargo();

		$cargo->setId($_POST['id']);
		$cargo->setCodigo($_POST['codigo']);
		$cargo->setNombre($_POST['nombre']);		
		
		$result = $cargo->actualizar();

		echo json_encode($result);
	            
	}
	
	public function activar(){
		$cargo = new Cargo();

		$cargo->setId($_POST['id']);

		$result = $cargo->activar();

		echo json_encode($result);
	}	
	
	public function desactivar(){
	    $cargo = new Cargo();

		$cargo->setId($_POST['id']);      

		$result = $cargo->desactivar();

		echo json_encode($result);   
	}	
}