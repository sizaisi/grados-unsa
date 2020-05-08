<?php
require_once 'models/Observaciones.php';

class ObservacionesController {

    public function show() {        
        $observaciones = new Observaciones();       
        
        $observaciones->setIdGradoProc($_POST['idgrado_proc']);
        $observaciones->setIdUsuario($_POST['idusuario']);
        $observaciones->setIdExpediente($_POST['idexpediente']);

        $result = $observaciones->getObservaciones();

        echo json_encode($result);           
	}
    
    public function store() {        
		$observaciones = new Observaciones();
  
        $observaciones->setDescripcion($_POST['descripcion']);
        $observaciones->setIdGradoProc($_POST['idgrado_proc']);
        $observaciones->setIdUsuario($_POST['idusuario']);
        $observaciones->setIdExpediente($_POST['idexpediente']);

        $result = $observaciones->insertar();        

        echo json_encode($result);           
    }	
    
    public function update() {        
		$observaciones = new Observaciones();
  
        $observaciones->setId($_POST['id']);       
        $observaciones->setDescripcion($_POST['descripcion']);

        $result = $observaciones->actualizar();        

        echo json_encode($result);           
	}	

	public function delete() {        
		$observaciones = new Observaciones();
  
        $observaciones->setId($_POST['id']);       

        $result = $observaciones->eliminar();        

        echo json_encode($result);            
	}	
}