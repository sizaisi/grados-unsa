<?php
require_once 'models/Usuario.php';

class UsuarioController {
	
	public function getIdUsuario() {
		$usuario = new Usuario();
		
		$usuario->setCodiUsuario($_POST['codi_usuario']);        

                $result = $usuario->getIdUsuario();
        
                echo json_encode($result);               
        }    
	
	public function getDocentes() {               
                $idexpediente = $_POST['idexpediente'];        

                $usuario = new Usuario();

                $result = $usuario->getDocentes($idexpediente);
        
                echo json_encode($result);   
	}	
}