<?php
require_once 'models/UsuarioExpediente.php';

class UsuarioExpedienteController {

    public function getAsesor() {        
        $usuario_expediente = new UsuarioExpediente();
        
        $usuario_expediente->setIdexpediente($_POST['idexpediente']);

        $result = $usuario_expediente->getAsesor();

        echo json_encode($result);           
	}
    
    public function store() {        
		$usuario_expediente = new UsuarioExpediente();
  
        $usuario_expediente->setIdexpediente($_POST['idexpediente']);
        $usuario_expediente->setIdusuario($_POST['idusuario']);
        $usuario_expediente->setTipo($_POST['tipo']);

        $result = $usuario_expediente->insertar();        

        echo json_encode($result);           
	}	

	public function delete() {
        
		$usuario_expediente = new UsuarioExpediente();
  
        $usuario_expediente->setId($_POST['id']);        

        $result = $usuario_expediente->eliminar();        

        echo json_encode($result);            
	}	
}