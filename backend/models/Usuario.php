<?php

class Usuario {
	private $id;
	private $codi_usuario;
	private $tipo;

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

	function getCodiUsuario() {
		return $this->codi_usuario;
	}

	function setCodiUsuario($codi_usuario) {
		$this->codi_usuario = $codi_usuario;
	}	

	function getTipo() {
		return $this->tipo;
	}

	function setTipo($tipo) {
		$this->tipo = $tipo;
	}
	
	public function getGraduando($idexpediente) {              

		$result = array('error' => false);		

		$sql = "SELECT GT_G.*, SUBSTRING(AC_I.dic, 2) AS dni, REPLACE(AC_I.apn,'/',' ') AS apell_nombres 
				FROM GT_USUARIO_EXPEDIENTE AS GT_UE 
				INNER JOIN GT_USUARIO AS GT_U ON GT_U.id = GT_UE.idusuario 
				INNER JOIN GT_GRADUANDO AS GT_G ON GT_G.cui = GT_U.codi_usuario 
				INNER JOIN acdiden AS AC_I ON AC_I.cui = GT_G.cui 
				WHERE GT_UE.idexpediente = $idexpediente";
  
		$result_query = mysqli_query($this->conn, $sql); 	
  
		if ($row = $result_query->fetch_assoc()) {         
		   $graduando = $row;
		}
  
		$result['graduando'] = $graduando;      
  
		return $result;
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
  
		if ($row = $result_query->fetch_assoc()) {         
		   $graduando = $row;
		}
  
		$result['graduando'] = $graduando;      
  
		return $result;
	 }   
  
	 public function getIdUsuario() {
		$result = array('error' => false);		

		$sql = "SELECT * 
				FROM GT_USUARIO
				WHERE codi_usuario = '$this->codi_usuario'";
		$result_query = mysqli_query($this->conn, $sql);		
  
		if ($result_query && mysqli_num_rows($result_query) > 0) {
			$row = $result_query->fetch_assoc();		   
			$result['usuario'] = $row;       
		}
		else {
			$result['error'] = true;
		   	$result['message'] = "No se pudo encontrar el usuario.";
		} 
		return $result;
	 }
  
	 //Obtener los asesores o jurados solo de la facultad a la que pertenece la socitud del expediente
	 public function getDocentes($idexpediente) {
  
		$result = array('error' => false);
  
		$sql = "SELECT gt_u.id, REPLACE(ac_doc.apn,'/',' ') AS apn, ac_doc.dic AS nro_documento " .
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

		if ($result_query) {
			$array_docente = array();
  
			while ($row = $result_query->fetch_assoc()) {         
			array_push($array_docente, $row);
			}
	
			$result['array_docente'] = $array_docente;
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo obtener los docentes.";    
		}	      
  
		return $result;
	 }      
}