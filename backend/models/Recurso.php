<?php

class Recurso {
	protected $id;
	protected $idexpediente;
    protected $idgrado_proc;
    protected $idusuario;    
    protected $idmovimiento;
    protected $idruta;		
	
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

	public function getIdExpediente() {
		return $this->idexpediente;
	}

	function setIdExpediente($idexpediente) {
		$this->idexpediente = $idexpediente;
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
    
    function getIdMovimiento() {
		return $this->idmovimiento;
	}

	function setIdMovimiento($idmovimiento) {
		$this->idmovimiento = $idmovimiento;
    }	
    
    function getIdRuta() {
		return $this->idruta;
	}

	function setIdRuta($idruta) {
		$this->idruta = $idruta;
	}	
	
	//verificar si existe recursos en otras rutas del mismo procedimiento sin confirmacion (no hay movimiento)
	public function verificarRecursosVecinos() {
  
		$result = array('error' => false);
  
		$sql = "SELECT GT_RE.*
			    FROM GT_RECURSO AS GT_RE			    
			    WHERE GT_RE.idexpediente = $this->idexpediente 
				AND GT_RE.idgrado_proc = $this->idgrado_proc 
				AND GT_RE.idusuario = $this->idusuario 
				AND GT_RE.idruta <> $this->idruta 
				AND GT_RE.idmovimiento IS NULL 
				AND GT_RE.idruta IN (SELECT id
								     FROM GT_RUTA AS GT_R 								   
								     wHERE GT_R.idgradproc_origen = $this->idgrado_proc)";
  
		$result_query = mysqli_query($this->conn, $sql);

		if ($result_query) {  
			if (mysqli_num_rows($result_query) == 0) {         
				$result['existeRecursoRutaVecinas'] = false;
			}
			else {
				$result['existeRecursoRutaVecinas'] = true;
			}			
		}
		else {
			$result['error'] = $sql;
			$result['message'] = "No se pudo verificar recursos en rutas vecinas.";    
		}	      
  
		return $result;
	}   
}