<?php
require_once 'models/GradoProcedimiento.php';
require_once "models/GradoModalidad.php";
require_once "models/Procedimiento.php";
require_once "models/RolArea.php";

class GradoProcedimientoController {
	
	public function index(){
		$grado_procedimiento = new GradoProcedimiento();

		$result = $grado_procedimiento->getAllGradoProcedimiento();

		echo json_encode($result);            
	}

	public function getGradoProcedimiento() {
		$grado_procedimiento = new GradoProcedimiento();		
		$grado_procedimiento->setId($_POST['idgrado_procedimiento']);

		$result = $grado_procedimiento->getGradoProcedimiento();

		echo json_encode($result);            
	}

	public function menu_dinamico() {		
		$grado_procedimiento = new GradoProcedimiento();      

		$grado_procedimiento->setIdGradoModalidad($_POST['idgrado_modalidad']);
		$grado_procedimiento->setIdRolArea($_POST['idrol_area']);

		$idusuario = $_POST['idusuario'];

		$result = $grado_procedimiento->listar_menus($idusuario);

		echo json_encode($result);           
	}

	public function readGradoModalidad(){
		$grado_modalidad = new GradoModalidad();

		$result = $grado_modalidad->getActives();

		echo json_encode($result);            
	}

	public function readProcedimientos(){
		$procedimiento = new Procedimiento();

		$result = $procedimiento->getActives();

		echo json_encode($result);	
	}

	public function readRolArea(){
		$rol_area = new RolArea();

		$result = $rol_area->getAllRolArea();

		echo json_encode($result);           
	}
	
	public function store(){
		$grado_procedimiento = new GradoProcedimiento();

		$grado_procedimiento->setIdGradoModalidad($_POST['idgrado_modalidad']);
		$grado_procedimiento->setIdProcedimiento($_POST['idprocedimiento']);
		$grado_procedimiento->setIdrol($_POST['idrol_area']);   
		$grado_procedimiento->setTipoRol($_POST['tipo_rol']);      
		$grado_procedimiento->setUrl($_POST['url_formulario']);
		$grado_procedimiento->setOrden($_POST['orden']);

		$result = $grado_procedimiento->insertar();

		echo json_encode($result);     
	}
	
	public function update(){
		$grado_procedimiento = new GradoProcedimiento();

		$grado_procedimiento->setId($_POST['id']);
		$grado_procedimiento->setIdGradoModalidad($_POST['idgrado_modalidad']);
		$grado_procedimiento->setIdProcedimiento($_POST['idprocedimiento']);
		$grado_procedimiento->setIdrol($_POST['idrol_area']);   
		$grado_procedimiento->setTipoRol($_POST['tipo_rol']);      
		$grado_procedimiento->setUrl($_POST['url_formulario']);
		$grado_procedimiento->setOrden($_POST['orden']);

		$result = $grado_procedimiento->actualizar();

		echo json_encode($result);            
	}
	
	public function activar(){
		$grado_procedimiento = new GradoProcedimiento();

		$grado_procedimiento->setId($_POST['id']);

		$result = $grado_procedimiento->activar();

		echo json_encode($result);             
	}	
	
	public function desactivar(){
		$grado_procedimiento = new GradoProcedimiento();

		$grado_procedimiento->setId($_POST['id']);

		$result = $grado_procedimiento->desactivar();

		echo json_encode($result);             
	}	
}