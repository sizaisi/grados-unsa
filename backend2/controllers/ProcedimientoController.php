<?php
require_once 'models/Procedimiento.php';

class ProcedimientoController {
	
	public function index(){
		$procedimiento = new Procedimiento();

		$result = $procedimiento->getAllProcedimiento();

		echo json_encode($result);           
	}
	
	public function store(){
		$procedimiento = new Procedimiento();

		$procedimiento->nombre = $_POST['nombre'];
		$procedimiento->descripcion = $_POST['descripcion'];

		$result = $procedimiento->insertar();

		echo json_encode($result);      
	}
	
	public function update(){
		$procedimiento = new Procedimiento();

		$procedimiento->id = $_POST['id'];
		$procedimiento->nombre = $_POST['nombre'];
		$procedimiento->descripcion = $_POST['descripcion'];

		$result = $procedimiento->actualizar();

		echo json_encode($result);            
	}
	
	public function activar(){
		$procedimiento = new Procedimiento();

		$procedimiento->id = $_POST['id'];

		$result = $procedimiento->activar();

		echo json_encode($result);           
	}	
	
	public function desactivar(){
		$procedimiento = new Procedimiento();

		$procedimiento->id = $_POST['id'];      

		$result = $procedimiento->desactivar();

		echo json_encode($result);             
	}	
}