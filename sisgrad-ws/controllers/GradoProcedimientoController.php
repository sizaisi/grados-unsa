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
	
	public function gradoProcedimientos() {		
		$grado_procedimiento = new GradoProcedimiento();      

		$grado_procedimiento->setIdGradoModalidad($_POST['idgrado_modalidad']);
		$grado_procedimiento->setIdRolArea($_POST['idrol_area']);

		$idusuario = $_POST['idusuario'];
		$codi_usuario = $_POST['codi_usuario'];
		$tipo_usuario = $_POST['tipo_usuario'];

		$result = $grado_procedimiento->getGradoProcedimientos($idusuario, $codi_usuario, $tipo_usuario);

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
		$grado_procedimiento->setIdRolArea($_POST['idrol_area']);   
		$grado_procedimiento->setTipoRol($_POST['tipo_rol']);      
		$grado_procedimiento->setUrl($_POST['url_formulario']);
		$grado_procedimiento->setOrden($_POST['orden']);
		$grado_procedimiento->setDescripcion($_POST['descripcion']);

		$result = $grado_procedimiento->insertar();

		echo json_encode($result);     
	}
	
	public function update(){
		$grado_procedimiento = new GradoProcedimiento();

		$grado_procedimiento->setId($_POST['id']);
		$grado_procedimiento->setIdGradoModalidad($_POST['idgrado_modalidad']);
		$grado_procedimiento->setIdProcedimiento($_POST['idprocedimiento']);
		$grado_procedimiento->setIdRolArea($_POST['idrol_area']);   
		$grado_procedimiento->setTipoRol($_POST['tipo_rol']);      
		$grado_procedimiento->setUrl($_POST['url_formulario']);
		$grado_procedimiento->setOrden($_POST['orden']);
		$grado_procedimiento->setDescripcion($_POST['descripcion']);

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