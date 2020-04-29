<?php
require_once 'models/Caja.php';

class CajaController {
	
	public function index(){
          
	}
	
	public function store(){
   
	}
	
	public function update(){
           
	}
	
	public function activar(){
            
	}	
	
	public function desactivar(){
          
	}	

	public function getPagosCajaProfesionalTesis(){
		$servicio_caja = new ServicioCaja();
        
        $cui = '20143489';
        $depe = '450';        

        $result = $servicio_caja->getPagosCajaProfesionalTesis($cui, $depe);

        echo json_encode($result);
	}
}