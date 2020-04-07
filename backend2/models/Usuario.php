<?php

class Usuario {
	private $id;
	private $codi_usuario;
	private $tipo;
	
	public function __construct() {
		$this->conexion = Database::conectar();
	}
	
	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}

	function getCodi_Usuario() {
		return $this->codi_usuario;
	}

	function setCodi_Usuario($codi_usuario) {
		$this->codi_usuario = $this->conexion->real_escape_string($codi_usuario);
	}	

	function getTipo() {
		return $this->tipo;
	}

	function setTipo($tipo) {
		$this->tipo = $this->conexion->real_escape_string($tipo);
	}
	
	public function getGradByIdExp($idexpediente) {

		$result = array('error' => false);
  
		$sql = "SELECT gt_g.*, SUBSTRING(ac_i.dic, 2) AS dni, REPLACE(ac_i.apn,'/',' ') AS apell_nombres 
				FROM GT_USUARIO_EXPEDIENTE AS gt_ue
				INNER JOIN GT_USUARIO AS gt_u ON gt_ue.idusuario = gt_u.id
				INNER JOIN GT_GRADUANDO AS gt_g ON gt_u.codi_usuario = gt_g.cui
				INNER JOIN acdiden AS ac_i ON gt_g.cui = ac_i.cui
				WHERE idexpediente = $idexpediente
				ORDER BY ac_i.apn ASC";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		$array_graduando = array();
  
		while ($row = $result_query->fetch_assoc()) {         
		   array_push($array_graduando, $row);
		}
  
		$result['array_graduando'] = $array_graduando;      
  
		return $result;
	 }   
  
	 public function getIdUsuario() {
		$result = array('error' => false);
		//seleccionar idusuario
		$sql = "SELECT id AS idusuario
				FROM GT_USUARIO
				WHERE codi_usuario = '$this->codi_usuario'";
		$result_query = mysqli_query($this->conn, $sql);
		$row = $result_query->fetch_assoc();
  
		if ($row['idusuario'] == null) {
		   $result['error'] = true;
		   $result['message'] = "No se pudo encontrar el usuario.";
		}
		
		$result['idusuario'] = $row['idusuario'];       
  
		return $result;
	 }
  
	 //Obtener los asesores o jurados solo de la facultad a la que pertenece la socitud del expediente
	 public function getDocentes($idexpediente) {
  
		$result = array('error' => false);
  
		$sql = "SELECT gt_u.id AS iddocente, REPLACE(ac_doc.apn,'/',' ') as apell_nombres " .
			   "FROM GT_USUARIO AS gt_u " .
			   "INNER JOIN SIAC_DOC AS ac_doc ON gt_u.codi_usuario = ac_doc.codper " .             
			   "INNER JOIN actdepa AS ac_d ON ac_doc.depend = ac_d.depa " .             
			   "WHERE ac_d.facu = (SELECT ac_e.facu " .
								  "FROM GT_EXPEDIENTE AS gt_e " .
								  "INNER JOIN actescu ac_e ON gt_e.nues = ac_e.nues " .
								  "WHERE gt_e.id = $idexpediente) " .
			   "AND ac_doc.esta_doc = 'A' " .             
			   "ORDER BY ac_doc.apn ASC";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		$array_docente = array();
  
		while ($row = $result_query->fetch_assoc()) {         
		   array_push($array_docente, $row);
		}
  
		$result['array_docente'] = $array_docente;      
  
		return $result;
	 }      
}