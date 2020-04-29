<?php
require_once 'models/Archivo.php';

class ArchivoController {
	
	public function index(){
		$archivo = new Archivo();        

		$archivo->setIdexpediente($_POST['idexpediente']);

        $result = $archivo->getTodosArchivos();

        echo json_encode($result);           
	}

	public function getDocumento() {
		$archivo = new Archivo();        

        $archivo->setIdgrado_Proc($_POST['idgrado_proc']);
        $archivo->setIdusuario($_POST['idusuario']);
        $archivo->setIdexpediente($_POST['idexpediente']);

        $result = $archivo->getDocumento();

        echo json_encode($result);       
	}
	
	public function store() {
		$archivo = new Archivo();        

        $archivo->setNombre($_POST['nombre']);
        $archivo->setData(base64_encode(file_get_contents($_FILES['data']['tmp_name'])));
        $archivo->setExtension($_FILES['data']['type']);
        $archivo->setIdgrado_Proc($_POST['idgrado_proc']);
        $archivo->setIdusuario($_POST['idusuario']);
        $archivo->setIdexpediente($_POST['idexpediente']);       

        $result = $archivo->storeDocumento();

        echo json_encode($result); 
        //echo 'idexpediente: '.$_POST['idexpediente'].' idusuario: '.$_POST['idusuario'];
	}	
		
	public function delete() {
		$archivo = new Archivo();        

        $archivo->setId($_POST['id']);        

        $result = $archivo->deleteDocumento();

        echo json_encode($result);           
    }
    
    public function show() {

    }
}