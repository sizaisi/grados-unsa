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

		$cargo->setNombre($_POST['nombre']);

		$cargo->setTipo($_POST['tipo']);

		$result = $cargo->insertar();

		echo json_encode($result);
	}
	
	public function update(){
		$cargo = new Cargo();

		$cargo->setId($_POST['id']);
		$cargo->setNombre($_POST['nombre']);
		$cargo->setTipo($_POST['tipo']);
		
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