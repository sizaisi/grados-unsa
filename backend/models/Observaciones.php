<?php

class Observaciones {
	private $id;
	private $descripcion;
	private $idgrado_proc;
    private $idusuario;
    private $idexpediente;

	private $conn;
	
	public function __construct() {
		$this->conn = Database::conectar();
	}
	
	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
    }
    
    function getDescripcion() {
		return $this->descripcion;
	}

	function setDescripcion($descripcion) {
		$this->descripcion = $descripcion;
    }

    function getIdGradoProc() {
		return $this->idgrado_proc;
	}

	function setIdGradoProc($idgrado_proc) {
		$this->idgrado_proc = $idgrado_proc;
    }

    function getIdUsuario() {
		return $this->idusuario;
	}

	function setIdUsuario($idusuario) {
		$this->idusuario = $idusuario;
    }

	function getIdExpediente() {
		return $this->idexpediente;
	}

	function setIdExpediente($idexpediente) {
		$this->idexpediente = $idexpediente;
	}	
	
	public function getObservaciones() {

		$result = array('error' => false);
  
		$sql = "SELECT id, descripcion FROM GT_OBSERVACION WHERE idgrado_proc = $this->idgrado_proc 
                AND idusuario = $this->idusuario AND idexpediente = $this->idexpediente";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		$array_observaciones = array();
  
		while ($row = $result_query->fetch_assoc()) {         
		   array_push($array_observaciones, $row);
		}
  
		$result['array_observaciones'] = $array_observaciones;
  
		return $result;
	}      
  
	public function insertar() {      
  
		$result = array('error' => false);
  
		$sql = "INSERT INTO GT_OBSERVACION(descripcion, idgrado_proc, idusuario, idexpediente) 
				 VALUES ('$this->descripcion', $this->idgrado_proc, $this->idusuario, $this->idexpediente)";
		
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Observaciones registradas correctamente.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudieron registrar las observaciones.";
		}      
  
		return $result;
    }
    
    public function actualizar() {      
  
		$result = array('error' => false);
  
		$sql = "UPDATE GT_OBSERVACION SET descripcion = '$this->descripcion' WHERE id = $this->id";
		
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Observaciones actualizadas correctamente.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudieron actualizar las observaciones.";
		}      
  
		return $result;
	}
  
	public function eliminar() {      
  
		$result = array('error' => false);
  
		$sql = "DELETE FROM GT_OBSERVACION where id = $this->id";
		
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Observaciones eliminadas correctamente.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudieron eliminar las observaciones.";
		}      
  
		return $result;
	 }
}