<?php
require_once 'models/GradoModalidad.php';

class GradoModalidadController {
	
	public function index(){
		$grado_modalidad = new GradoModalidad();

		$result = $grado_modalidad->getAllGradoModalidad();

		echo json_encode($result);          
	}
	
	public function store(){
		$grado_modalidad = new GradoModalidad();

		$grado_modalidad->idgrado_titulo = $_POST['idgrado_titulo'];
		$grado_modalidad->idmodalidad_obtencion = $_POST['idmodalidad_obtencion'];

		$result = $grado_modalidad->insertar();

		echo json_encode($result);       
	}
	
	public function update(){
		$grado_modalidad = new GradoModalidad();

		$grado_modalidad->id = $_POST['id'];
		$grado_modalidad->idgrado_titulo = $_POST['idgrado_titulo'];
		$grado_modalidad->idmodalidad_obtencion = $_POST['idmodalidad_obtencion'];
		
		$result = $grado_modalidad->actualizar();

		echo json_encode($result);            
	}
	
	public function activar(){
		$grado_modalidad = new GradoModalidad();

		$grado_modalidad->id = $_POST['id'];

		$result = $grado_modalidad->activar();

		echo json_encode($result);           
	}	
	
	public function desactivar(){
		$grado_modalidad = new GradoModalidad();

		$grado_modalidad->id = $_POST['id'];      

		$result = $grado_modalidad->desactivar();

		echo json_encode($result);            
	}	
}