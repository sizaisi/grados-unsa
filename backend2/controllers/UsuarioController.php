<?php
require_once 'models/Usuario.php';

class UsuarioController {
	
	public function getIdUsuario() {
		$usuario = new Usuario();
		//$usuario->codi_usuario = $_GET['codi_usuario'];        
		$usuario->setCodiUsuario($_POST['codi_usuario']);        

        $result = $usuario->getIdUsuario();
   
        echo json_encode($result);               
	}
	
	public function getGradByIdExp() {
		//$idexpediente = $_GET['idexpediente'];        
		$idexpediente = $_POST['idexpediente'];        

        $usuario = new Usuario();

        $result = $usuario->getGradByIdExp($idexpediente);
   
        echo json_encode($result);     
	}

	public function getDocentes() {
		$idexpediente = $_GET['idexpediente'];        

        $usuario = new Usuario();

        $result = $usuario->getDocentes($idexpediente);
   
        echo json_encode($result);   
	}
	
	public function getExpJurados() {
		$idexpediente = $_GET['idexpediente'];        

        $usuario_expediente = new UsuarioExpediente();

        $result = $usuario_expediente->getExpJurados($idexpediente);

        echo json_encode($result);             
	}
	
	public function getAsesor() {
		$idexpediente = $_GET['idexpediente'];        

        $usuario_expediente = new UsuarioExpediente();

        $result = $usuario_expediente->getAsesor($idexpediente);
   
        echo json_encode($result);                
	}	
	
	public function getNombreAsesor() {
		$idexpediente = $_GET['idexpediente'];        

        $usuario_expediente = new UsuarioExpediente();

        $result = $usuario_expediente->getNombreAsesor($idexpediente);
   
        echo json_encode($result);
           
	}	

	public function storeAsesor() {
		$usuario_expediente = new UsuarioExpediente();
  
        $usuario_expediente->idexpediente = $_POST['idexpediente'];
        $usuario_expediente->idusuario = $_POST['iddocente'];
        $usuario_expediente->tipo = 'asesor';

        $result = $usuario_expediente->insertar_asesor();        

        echo json_encode($result);            
	}	

	public function deleteAsesor() {
		$usuario_expediente = new UsuarioExpediente();
    
        $usuario_expediente->id = $_POST['id'];        

        $result = $usuario_expediente->deleteAsesor();        

        echo json_encode($result);
           
	}	

	public function storeJurado() {
		$usuario_expediente = new UsuarioExpediente();
  
        $usuario_expediente->idexpediente = $_POST['idexpediente'];
        $usuario_expediente->idusuario = $_POST['iddocente'];
        $usuario_expediente->tipo = $_POST['tipo'];

        $result = $usuario_expediente->insertar_jurado();        

        echo json_encode($result);           
	}	

	public function deleteJurado() {
		$usuario_expediente = new UsuarioExpediente();
  
        $usuario_expediente->id = $_POST['id'];        

        $result = $usuario_expediente->eliminar_jurado();        

        echo json_encode($result);            
	}	
}