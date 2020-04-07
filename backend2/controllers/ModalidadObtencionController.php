<?php
require_once 'models/ModalidadObtencion.php';

class ModalidadObtencionController {
	
	public function index(){
		$modalidad_obtencion = new ModalidadObtencion();

		$result = $modalidad_obtencion->getAllModalidadObtencion();

		echo json_encode($result);
	}
	
	public function store(){
		$modalidad_obtencion = new ModalidadObtencion();

		$modalidad_obtencion->setNombre($_POST['nombre']);

		$result = $modalidad_obtencion->insertar();

		echo json_encode($result);
	}
	
	public function update(){
		$modalidad_obtencion = new ModalidadObtencion();

		$modalidad_obtencion->setId($_POST['id']);
		$modalidad_obtencion->setNombre($_POST['nombre']);
		
		$result = $modalidad_obtencion->actualizar();

		echo json_encode($result);
	            
	}
	
	public function activar(){
		$modalidad_obtencion = new ModalidadObtencion();

		$modalidad_obtencion->setId($_POST['id']);

		$result = $modalidad_obtencion->activar();

		echo json_encode($result);
	}	
	
	public function desactivar(){
	    $modalidad_obtencion = new ModalidadObtencion();

		$modalidad_obtencion->setId($_POST['id']);      

		$result = $modalidad_obtencion->desactivar();

		echo json_encode($result);   
	}	
}