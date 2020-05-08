<?php

class UsuarioExpediente {
	private $id;
	private $idexpediente;
	private $idusuario;
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

	function getIdexpediente() {
		return $this->idexpediente;
	}

	function setIdexpediente($idexpediente) {
		$this->idexpediente = $idexpediente;
	}	

	function getIdusuario() {
		return $this->idusuario;
	}

	function setIdusuario($idusuario) {
		$this->idusuario = $idusuario;
	}

	function getTipo() {
		return $this->tipo;
	}

	function setTipo($tipo) {
		$this->tipo = $tipo;
	}
	
	public function getListAsesor($idexpediente) {

		$result = array('error' => false);
  
		$sql = "SELECT GT_UE.id, REPLACE(AC_D.apn, '/', ' ') AS nombre_docente, AC_DE.ndep AS departamento
				FROM GT_USUARIO_EXPEDIENTE AS GT_UE
				INNER JOIN GT_USUARIO AS GT_U ON GT_UE.idusuario = GT_U.id                
				INNER JOIN SIAC_DOC AS AC_D ON GT_U.codi_usuario = AC_D.codper
				INNER JOIN actdepa AS AC_DE ON AC_D.depend = AC_DE.depa
				WHERE GT_UE.idexpediente = $idexpediente AND GT_UE.tipo = 'asesor'";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		$array_asesor = array();
  
		while ($row = $result_query->fetch_assoc()) {         
		   array_push($array_asesor, $row);
		}
  
		$result['array_asesor'] = $array_asesor;
  
		return $result;
	 }    
  
	 public function getAsesor() {
  
		$result = array('error' => false);
  
		$sql = "SELECT GT_UE.id, GT_UE.tipo, REPLACE(AC_D.apn, '/', ' ') AS apn, AC_D.dic AS nro_documento	
				FROM GT_USUARIO_EXPEDIENTE AS GT_UE
				INNER JOIN GT_USUARIO AS GT_U ON GT_UE.idusuario = GT_U.id                
				INNER JOIN SIAC_DOC AS AC_D ON GT_U.codi_usuario = AC_D.codper
				WHERE GT_UE.idexpediente = $this->idexpediente AND GT_UE.tipo = 'asesor'";

		$result_query = mysqli_query($this->conn, $sql);

		if ($result_query) {			
			if (mysqli_num_rows($result_query) > 0) {
				$row = $result_query->fetch_assoc();        
				$result['asesor'] = $row;
			}			
			else {
				$result['error'] = true;
				$result['message'] = "No se pudo encontrar el asesor.";            
			}			
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo obtener el asesor.";            
		}		
  
		return $result;
	 }       
  
	 public function getJurados($idexpediente) {
  
		$result = array('error' => false);
		
		$sql = "SELECT GT_UE.id, GT_UE.idexpediente, GT_UE.idusuario, GT_UE.tipo, REPLACE(AC_D.apn, '/', ' ') AS nombre
				FROM GT_USUARIO_EXPEDIENTE AS GT_UE
				INNER JOIN GT_USUARIO AS GT_U ON GT_UE.idusuario = GT_U.id                
				INNER JOIN SIAC_DOC AS AC_D ON GT_U.codi_usuario = AC_D.codper
				WHERE GT_UE.tipo <> 'granduado' AND  GT_UE.tipo <> 'asesor' 
				AND GT_UE.idexpediente = $idexpediente
				ORDER BY GT_UE.id ASC";

		$result_query = mysqli_query($this->conn, $sql);

		if ($result_query) {			
			$array_jurado = array();
	
			while ($row = $result_query->fetch_assoc()) {         
				array_push($array_jurado, $row);
			}
	
			$result['array_jurado'] = $array_jurado;   			
		}
		else {  
			$result['error'] = true;
			$result['message'] = "No se pudo obtener los nombres de jurados.";            
		}					
  
		return $result;
	 }    
  
	 /*public function insertar_asesor() {      
  
		$result = array('error' => false);
  
		$sql = "INSERT INTO GT_USUARIO_EXPEDIENTE(idexpediente, idusuario, tipo) 
				 VALUES ($this->idexpediente, $this->idusuario, '$this->tipo')";
		
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Asesor agregado correctamente.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudo agregar el asesor.";;
		}      
  
		return $result;
	 }
  
	 public function deleteAsesor(){
		$result = array('error' => false);      
  
		$sql = "DELETE FROM GT_USUARIO_EXPEDIENTE WHERE id = $this->id";
		
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
			$result['message'] = "Asesor eliminado correctamente.";
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo eliminar el asesor.";
		}           
  
		return $result;
	 }*/
  
	 public function insertar() {      
  
		$result = array('error' => false);
  
		$sql = "INSERT INTO GT_USUARIO_EXPEDIENTE(idexpediente, idusuario, tipo) 
				 VALUES ($this->idexpediente, $this->idusuario, '$this->tipo')";
		
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Docente agregado correctamente.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudo agregar el docente.";
		}      
  
		return $result;
	 }
  
	 public function eliminar() {      
  
		$result = array('error' => false);
  
		$sql = "DELETE FROM GT_USUARIO_EXPEDIENTE where id = $this->id";
		
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Docente eliminado correctamente.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudo eliminar el docente.";
		}      
  
		return $result;
	 }
}