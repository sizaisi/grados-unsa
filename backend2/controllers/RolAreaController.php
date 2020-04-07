<?php
require_once 'models/RolArea.php';

class RolAreaController {
	
	public function index(){
		$rol_area = new RolArea();

		$result = $rol_area->getAllRolArea();
  
		echo json_encode($result);          
	}
	
	public function store(){
		$rol_area = new RolArea();

		$rol_area->nombre = $_POST['nombre'];

		$result = $rol_area->insertar();

		echo json_encode($result);    
	}
	
	public function update(){
		$rol_area = new RolArea();

		$rol_area->id = $_POST['id'];
		$rol_area->nombre = $_POST['nombre'];
		
		$result = $rol_area->actualizar();

		echo json_encode($result);           
	}
	
	public function activar(){
		$rol_area = new RolArea();

		$rol_area->id = $_POST['id'];      

		$result = $rol_area->activar();
		echo json_encode($result);           
	}	
	
	public function desactivar(){
		$rol_area = new RolArea();

		$rol_area->id = $_POST['id'];      

		$result = $rol_area->desactivar();
		echo json_encode($result);           
	}	
}