<?php
require_once 'models/Persona.php';

class PersonaController {    
    
	public function show_asesor() {        
        $persona = new Persona();       
        
        $persona->setIdExpediente($_POST['idexpediente']);
        $persona->setIdGradoProc($_POST['idgrado_proc']);
        $persona->setIdUsuario($_POST['idusuario']);       

        $result = $persona->getAsesor();

        echo json_encode($result);           
	}
	
	public function store() {
		$persona = new Persona();        
        
        $persona->setIdExpediente($_POST['idexpediente']);
        $persona->setIdGradoProc($_POST['idgrado_proc']);
        $persona->setIdUsuario($_POST['idusuario']);
        $persona->setIdRuta($_POST['idruta']);
        $persona->setIdDocente($_POST['iddocente']);
        $persona->setTipo($_POST['tipo']);       

        $result = $persona->insertar();

        echo json_encode($result);           
	}	
		
	public function delete() {        
		$persona = new Persona();
  
        $persona->setId($_POST['id']);       

        $result = $persona->eliminar();        

        echo json_encode($result);            
	}
    
}