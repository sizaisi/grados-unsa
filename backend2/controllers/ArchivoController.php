<?php
require_once 'models/Archivo.php';

class ArchivoController {
	
	public function index(){
		$archivo = new Archivo();        

		//$archivo->idexpediente = $_GET['idexpediente'];
		$archivo->setIdexpediente($_POST['idexpediente']);

        $result = $archivo->getTodosArchivos();

        echo json_encode($result);           
	}
	
	public function store(){
		$archivo = new Archivo();        

        $archivo->nombre = $_POST['nombre'];
        $archivo->data = base64_encode(file_get_contents($_FILES['data']['tmp_name']));
        $archivo->extension = $_FILES['data']['type'];
        $archivo->idgrado_proc = $_POST['idgrado_proc'];
        $archivo->idusuario = $_POST['idusuario'];
        $archivo->idexpediente = $_POST['idexpediente'];       

        $result = $archivo->storeDocumento();

        echo json_encode($result); 
	}
	
	public function update(){

	}
	
	public function activar(){
          
	}	
	
	public function desactivar(){
        
	}	
	public function delete(){
		$archivo = new Archivo();        

        $archivo->id = $_POST['id'];        

        $result = $archivo->deleteDocumento();

        echo json_encode($result);           
	}
}