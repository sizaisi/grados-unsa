<?php
require_once 'models/GradoModalidad.php';
require_once "models/GradoTitulo.php";
require_once "models/ModalidadObtencion.php";

class GradoModalidadController {

	public function inicioAdminitrativo() {		
		$codi_usuario = $_POST['codi_usuario'];
		$idrol_area = $_POST['idrol_area'];		

      	$grado_modalidad = new GradoModalidad();

      	$result = $grado_modalidad->getAllGradoModalidadAdministrativo($codi_usuario, $idrol_area);

      	echo json_encode($result);          
	}

	public function inicioDocente() {		
		$codi_usuario = $_POST['codi_usuario'];
		$idrol_area = $_POST['idrol_area'];		

      	$grado_modalidad = new GradoModalidad();

      	$result = $grado_modalidad->getAllGradoModalidadDocente($codi_usuario, $idrol_area);

      	echo json_encode($result);          
	}

	public function readGradoTitulo(){
		$grado_titulo = new GradoTitulo();

      	$result = $grado_titulo->getActives();

      	echo json_encode($result);          
	}

	public function readModObtencion(){
		$modalidad_obtencion = new ModalidadObtencion();

      	$result = $modalidad_obtencion->getActives();

      	echo json_encode($result);         
	}	

	public function index(){
		$grado_modalidad = new GradoModalidad();

      	$result = $grado_modalidad->getAllGradoModalidad();

      	echo json_encode($result);         
	}
	
	public function store(){
		$grado_modalidad = new GradoModalidad();

		$grado_modalidad->setIdGradoTitulo($_POST['idgrado_titulo']);
		$grado_modalidad->setIdModalidadObtencion($_POST['idmodalidad_obtencion']);

		$result = $grado_modalidad->insertar();

		echo json_encode($result);       
	}
	
	public function update(){
		$grado_modalidad = new GradoModalidad();

		$grado_modalidad->setId($_POST['id']);
		$grado_modalidad->setIdGradoTitulo($_POST['idgrado_titulo']);
		$grado_modalidad->setIdModalidadObtencion($_POST['idmodalidad_obtencion']);
		
		$result = $grado_modalidad->actualizar();

		echo json_encode($result);            
	}
	
	public function activar(){
		$grado_modalidad = new GradoModalidad();

		$grado_modalidad->setId($_POST['id']);

		$result = $grado_modalidad->activar();

		echo json_encode($result);           
	}	
	
	public function desactivar(){
		$grado_modalidad = new GradoModalidad();

		$grado_modalidad->setId($_POST['id']);      

		$result = $grado_modalidad->desactivar();

		echo json_encode($result);            
	}	
}