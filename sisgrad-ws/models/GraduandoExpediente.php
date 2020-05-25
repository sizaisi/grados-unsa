<?php

class GraduandoExpediente {
	private $idgraduando;
	private $idexpediente;	

	private $conn;
	
	public function __construct() {
		$this->conn = Database::conectar();
	}
	
	function getIdGraduando() {
		return $this->idgraduando;
	}

	function setIdGraduando($idgraduando) {
		$this->idgraduando = $idgraduando;
	}

	function getIdExpediente() {
		return $this->idexpediente;
	}

	function setIdExpediente($idexpediente) {
		$this->idexpediente = $idexpediente;
	}	

	public function getGraduando() {              

		$result = array('error' => false);		

		$sql = "SELECT GT_G.id, GT_G.cui, GT_G.email, GT_G.telefono_fijo, GT_G.telefono_movil, GT_G.direccion,
				       SUBSTRING(AC_I.dic, 2) AS dni, REPLACE(AC_I.apn,'/',' ') AS apell_nombres 
				FROM GT_GRADUANDO_EXPEDIENTE AS GT_GE 				 
				INNER JOIN GT_GRADUANDO AS GT_G ON GT_G.id = GT_GE.idgraduando
				INNER JOIN acdiden AS AC_I ON AC_I.cui = GT_G.cui 
				WHERE GT_GE.idexpediente = $this->idexpediente";
  
		$result_query = mysqli_query($this->conn, $sql); 	
  
		if ($row = $result_query->fetch_assoc()) {         
		   $graduando = $row;
		}
  
		$result['graduando'] = $graduando;      
  
		return $result;
	}
	
}