<?php
require_once 'models/GradoTitulo.php';

class GradoTituloController {
	
	public function index(){
		$grado_titulo = new GradoTitulo();

		$result = $grado_titulo->getAllGradoTitulo();

		echo json_encode($result);
           
	}
	
	public function store(){
		$grado_titulo = new GradoTitulo();

		$grado_titulo->nombre = $_POST['nombre'];
		$grado_titulo->codigo = $_POST['codigo'];
		$grado_titulo->idprereq = $_POST['idprereq'];
		$grado_titulo->descripcion = $_POST['descripcion'];

		$result = $grado_titulo->insertar();

		echo json_encode($result);       
	}
	
	public function update(){
		$grado_titulo = new GradoTitulo();

		$grado_titulo->id = $_POST['id'];
		$grado_titulo->nombre = $_POST['nombre'];
		$grado_titulo->codigo = $_POST['codigo'];
		$grado_titulo->idprereq = $_POST['idprereq'];
		$grado_titulo->descripcion = $_POST['descripcion'];


		$result = $grado_titulo->actualizar();

		echo json_encode($result);             
	}
	
	public function activar(){
		$grado_titulo = new GradoTitulo();

		$grado_titulo->id = $_POST['id'];

		$result = $grado_titulo->activar();

		echo json_encode($result);            
	}	
	
	public function desactivar(){
		$grado_titulo = new GradoTitulo();

		$grado_titulo->id = $_POST['id'];      

		$result = $grado_titulo->desactivar();

		echo json_encode($result);            
	}	
}