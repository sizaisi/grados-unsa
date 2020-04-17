<?php
require_once 'models/Expediente.php';

class ExpedienteController {
	
	public function getListByIds() {
		//$idgrado_procedimiento = $_GET['idgrado_procedimiento'];
		//$codi_usuario = $_GET['codi_usuario'];
		$idgrado_procedimiento = $_POST['idgrado_procedimiento'];
                $codi_usuario = $_POST['codi_usuario'];

                $expediente = new Expediente();

                $result = $expediente->getListByIds($idgrado_procedimiento, $codi_usuario);
        
                echo json_encode($result);
	}
	
	public function getListByCodi() {
		$codi_usuario = $_GET['codi_usuario'];
  
        $expediente = new Expediente();
  
        $result = $expediente->getListByCodi($codi_usuario);
     
        echo json_encode($result); 
	}
	
	public function getMovByIdExp() {
        $idexpediente = $_GET['idexpediente']; 
      
        $expediente = new Expediente();
      
        $result = $expediente->getMovByIdExp($idexpediente);
         
        echo json_encode($result);
	}
	
	public function getExpById() {
        
                $expediente = new Expediente();
                //$idexpediente = $_GET['idexpediente'];        
                $expediente->setId($_POST['idexpediente']);                         

                $result = $expediente->getExpediente();
        
                echo json_encode($result);  
	}		
}