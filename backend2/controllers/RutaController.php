<?php
require_once "models/Ruta.php";
require_once "models/GradoModalidad.php";
require_once "models/GradoProcedimiento.php";

class RutaController {
	
	public function index(){
		$ruta = new Ruta();

		$result = $ruta->getAllRutas();

		echo json_encode($result);            
	}

	public function getRutasByProc() { // obtener rutas por cada procedimiento
		$ruta = new Ruta();

		//$ruta->setIdGradProcOrigen($_GET['idgradproc_origen']);
		$ruta->setIdGradProcOrigen($_POST['idgradproc_origen']);  		  

		$result = $ruta->getRutasByIdProcOrigen();

		echo json_encode($result);             
	}

	public function getListGradModalidad(){
		$grado_modalidad = new GradoModalidad();

		$result = $grado_modalidad->getActives();

		echo json_encode($result);           
	}

	public function getListGradProcedimientos(){
		$grado_procedimiento = new GradoProcedimiento();      
		
		$grado_procedimiento->setIdGradoModalidad($_POST['idgrado_modalidad']);      
		
		$result = $grado_procedimiento->getListByIdGradoModalidad();

		echo json_encode($result);       					  
	}
	
	public function store(){
		$ruta = new Ruta();

		$ruta->setIdGradProcOrigen($_POST['idgradproc_origen']);
		$ruta->setIdGradProcDestino($_POST['idgradproc_destino']);
		$ruta->setEtiqueta($_POST['etiqueta']);            

		$result = $ruta->insertar();

		echo json_encode($result);       
	}
	
	public function update(){
		$ruta = new Ruta();

		$ruta->setId($_POST['id']);
		$ruta->setIdGradProcOrigen($_POST['idgradproc_origen']);
		$ruta->setIdGradProcDestino($_POST['idgradproc_destino']);
		$ruta->setEtiqueta($_POST['etiqueta']);            

		$result = $ruta->actualizar();

		echo json_encode($result);             
	}
	
	public function activar(){
		$ruta = new Ruta();

		$ruta->setId($_POST['id']);

		$result = $ruta->activar();

		echo json_encode($result);             
	}	
	
	public function desactivar(){
		$ruta = new Ruta();

		$ruta->setId($_POST['id']);
  
		$result = $ruta->desactivar();
  
		echo json_encode($result);             
	}	
}