<?php
require_once 'models/ProgramaEstudios.php';

class ProgramaEstudiosController {
	
	public function index(){
		$programa_estudios = new ProgramaEstudios();

		$result = $programa_estudios->getAllProgramaEstudios();   
		
		echo json_encode($result);           
	}
	
	public function store(){
		$programa_estudios = new ProgramaEstudios();

		$programa_estudios->setNombre($_POST['nombre']);
		
		$result = $programa_estudios->insertar();
		
		echo json_encode($result);       
		//echo json_encode($_POST['nombre']);       
	}
	
	public function update(){
		$programa_estudios = new ProgramaEstudios();

		$programa_estudios->setId($_POST['id']);
		$programa_estudios->setNombre($_POST['nombre']);

		$result = $programa_estudios->actualizar();
		
		echo json_encode($result);            
	}
	
	public function activar(){
		$programa_estudios = new ProgramaEstudios();

		$programa_estudios->setId($_POST['id']);      

		$result = $programa_estudios->activar();
		
		echo json_encode($result);            
	}	
	
	public function desactivar(){
		$programa_estudios = new ProgramaEstudios();

		$programa_estudios->setId($_POST['id']);      

		$result = $programa_estudios->desactivar();
      
		echo json_encode($result);            
	}	
}