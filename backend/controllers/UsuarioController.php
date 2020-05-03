<?php
require_once 'models/Usuario.php';
require_once 'models/UsuarioExpediente.php';

class UsuarioController {
	
	public function getIdUsuario() {
		$usuario = new Usuario();
		
		$usuario->setCodiUsuario($_POST['codi_usuario']);        

                $result = $usuario->getIdUsuario();
        
                echo json_encode($result);               
	}
	
	public function getGradByIdExp() {		   
		$idexpediente = $_POST['idexpediente'];        

        $usuario = new Usuario();

        $result = $usuario->getGradByIdExp($idexpediente);
   
        echo json_encode($result);     
	}

	public function getDocentes() {               
                $idexpediente = $_POST['idexpediente'];        

                $usuario = new Usuario();

                $result = $usuario->getDocentes($idexpediente);
        
                echo json_encode($result);   
	}
	
	public function getJurados() {
		$idexpediente = $_POST['idexpediente'];        

                $usuario_expediente = new UsuarioExpediente();

                $result = $usuario_expediente->getJurados($idexpediente);

                echo json_encode($result);             
	}
	
	public function getListAsesor() {
		$idexpediente = $_GET['idexpediente'];        

                $usuario_expediente = new UsuarioExpediente();

                $result = $usuario_expediente->getListAsesor($idexpediente);
        
                echo json_encode($result);                
	}	
	
	public function getAsesor() {
		$idexpediente = $_POST['idexpediente'];        

                $usuario_expediente = new UsuarioExpediente();

                $result = $usuario_expediente->getAsesor($idexpediente);
        
                echo json_encode($result);           
	}	

	public function storeAsesor() {
		$usuario_expediente = new UsuarioExpediente();
  
                $usuario_expediente->setIdexpediente($_POST['idexpediente']);
                $usuario_expediente->setIdusuario($_POST['iddocente']);
                $usuario_expediente->setTipo('asesor');

                $result = $usuario_expediente->insertar_asesor();        

                echo json_encode($result);            
	}	

	public function deleteAsesor() {
		$usuario_expediente = new UsuarioExpediente();
    
                $usuario_expediente->setId($_POST['id']);        

                $result = $usuario_expediente->deleteAsesor();        

                echo json_encode($result);
           
	}	

	public function storeJurado() {
        
		$usuario_expediente = new UsuarioExpediente();
  
                $usuario_expediente->setIdexpediente($_POST['idexpediente']);
                $usuario_expediente->setIdusuario($_POST['iddocente']);
                $usuario_expediente->setTipo($_POST['tipo']);

                $result = $usuario_expediente->insertar_jurado();        

                echo json_encode($result);           
	}	

	public function deleteJurado() {
        
		$usuario_expediente = new UsuarioExpediente();
  
                $usuario_expediente->setId($_POST['id']);        

                $result = $usuario_expediente->eliminar_jurado();        

                echo json_encode($result);            
	}	
}