<?php
require_once 'models/Recurso.php';

class RecursoController { 
    
    public function verify() {
		$recurso = new Recurso();        

        $recurso->setIdExpediente($_POST['idexpediente']);
        $recurso->setIdGradoProc($_POST['idgrado_proc']);
        $recurso->setIdUsuario($_POST['idusuario']);
        $recurso->setIdRuta($_POST['idruta']);        

        $result = $recurso->verificarRecursosVecinos();

        echo json_encode($result);       
	}   
}