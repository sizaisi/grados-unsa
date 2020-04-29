<?php
require_once 'models/Pago.php';

class PagoController {
	
	public function index(){
          
	}
	
	public function store(){
		$pago = new Pago();

		$pago->idconcepto = $_POST['idconcepto'];
		$pago->concepto = $_POST['concepto'];
		$pago->monto = $_POST['monto'];
		$pago->fecha_pago = $_POST['fecha_pago'];
		$pago->nro_recibo = $_POST['nro_recibo'];
		$pago->idexpediente = $_POST['idexpediente'];

		$result = $pago->insertar();

		echo json_encode($result);       
	}
	
	public function update(){
         
	}
	
	public function activar(){
           
	}	
	
	public function desactivar(){
           
	}	
}