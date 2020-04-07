<?php

class Pago {
	private $id;
	private $idconcepto;
	private $concepto;
	private $monto;
	private $fecha_pago;
	private $nro_recibo;
	private $idexpediente;	
	
	public function __construct() {
		$this->conexion = Database::conectar();
	}
	
	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}

	function getIdconcepto() {
		return $this->idconcepto;
	}

	function setIdconcepto($idconcepto) {
		$this->idconcepto = $this->conexion->real_escape_string($idconcepto);
	}	

	function getConcepto() {
		return $this->concepto;
	}

	function setConcepto($concepto) {
		$this->concepto = $this->conexion->real_escape_string($concepto);
	}

	function getMonto() {
		return $this->monto;
	}

	function setMonto($monto) {
		$this->monto = $this->conexion->real_escape_string($monto);
	}

	function getFecha_Pago() {
		return $this->fecha_pago;
	}

	function setFecha_Pago($fecha_pago) {
		$this->fecha_pago = $this->conexion->real_escape_string($fecha_pago);
	}

	function getNro_Recibo() {
		return $this->nro_recibo;
	}

	function setNro_Recibo($nro_recibo) {
		$this->nro_recibo = $this->conexion->real_escape_string($nro_recibo);
	}

	function getIdexpediente() {
		return $this->idexpediente;
	}

	function setIdexpediente($idexpediente) {
		$this->idexpediente = $this->conexion->real_escape_string($idexpediente);
	}
	
	public function getPagosPorExpediente() {

		$result = array('error' => false);
  
		$sql = "SELECT * FROM GT_PAGO WHERE idexpediente = $this->idexpediente";
		$result_query = mysqli_query($this->conn, $sql);
  
		$array_pagos_expediente = array();
  
		while ($row = $result_query->fetch_assoc()) {         
		   array_push($array_pagos_expediente, $row);
		}
  
		$result['array_pagos_expediente'] = $array_pagos_expediente;      
  
		return $result;
	 }
  
	 public function insertar() {      
  
		$result = array('error' => false);
  
		$sql = "INSERT INTO GT_PAGO(idconcepto, concepto, monto, fecha_pago, nro_recibo, idexpediente)
				VALUES ($this->idconcepto, '$this->concepto', $this->monto,
						'$this->fecha_pago', '$this->nro_recibo', $this->idexpediente)";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Pago agregado correctamente.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudo agregar el pago.";
		}      
  
		return $result;
	 } 
}