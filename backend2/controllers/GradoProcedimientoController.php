<?php
require_once 'models/GradoProcedimiento.php';

class GradoProcedimientoController {
	
	public function index(){
		$grado_procedimiento = new GradoProcedimiento();

		$result = $grado_procedimiento->getAllGradoProcedimiento();

		echo json_encode($result);            
	}
	
	public function store(){
		$grado_procedimiento = new GradoProcedimiento();

		$grado_procedimiento->idgrado_modalidad = $_POST['idgrado_modalidad'];
		$grado_procedimiento->idprocedimiento = $_POST['idprocedimiento'];
		$grado_procedimiento->idrol = $_POST['idrol_area'];   
		$grado_procedimiento->tipo_rol = $_POST['tipo_rol'];      
		$grado_procedimiento->url = $_POST['url_formulario'];
		$grado_procedimiento->orden = $_POST['orden'];

		$result = $grado_procedimiento->insertar();

		echo json_encode($result);     
	}
	
	public function update(){
		$grado_procedimiento = new GradoProcedimiento();

		$grado_procedimiento->id = $_POST['id'];
		$grado_procedimiento->idgrado_modalidad = $_POST['idgrado_modalidad'];
		$grado_procedimiento->idprocedimiento = $_POST['idprocedimiento'];            
		$grado_procedimiento->idrol = $_POST['idrol_area'];
		$grado_procedimiento->tipo_rol = $_POST['tipo_rol'];
		$grado_procedimiento->url = $_POST['url_formulario'];      
		$grado_procedimiento->orden = $_POST['orden'];

		$result = $grado_procedimiento->actualizar();

		echo json_encode($result);            
	}
	
	public function activar(){
		$grado_procedimiento = new GradoProcedimiento();

		$grado_procedimiento->id = $_POST['id'];

		$result = $grado_procedimiento->activar();

		echo json_encode($result);             
	}	
	
	public function desactivar(){
		$grado_procedimiento = new GradoProcedimiento();

		$grado_procedimiento->id = $_POST['id'];

		$result = $grado_procedimiento->desactivar();

		echo json_encode($result);             
	}	
}